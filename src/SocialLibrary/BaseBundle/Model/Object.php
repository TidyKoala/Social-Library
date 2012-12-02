<?php

namespace SocialLibrary\BaseBundle\Model;

use Application\Sonata\UserBundle\User;
use SocialLibrary\BaseBundle\Model\ObjectInterface;
use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SocialLibrary\BaseBundle\Model\Object
 * 
 */

abstract class Object implements ObjectInterface
{
	/**
	 * @ORM\Column(type="string")
	 * 
	 * @var ArrayCollection owners
	 */
	protected $owners;
	
	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string name
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string")
	 * @Gedmo\Slug(fields={"name"})
	 *
	 * @var string nameSlug
	 */
	protected $nameSlug;
	
	/**
	 * @var ArrayCollection creators
	 */
	protected $creators;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->creators = new ArrayCollection();
		$this->owners = new ArrayCollection();
	}
	
	/**
     * {@inheritdoc}
	 */
	public function setOwners(ArrayCollection $owners) {
		$this->owners = $owners;
		
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
    public function getOwners() {
    	return $this->owners;
    }

    /**
     * {@inheritdoc}
     */
    public function addOwner(User $owner) {
        if (!in_array($owner, $this->owners, true)) {
            $this->owners[] = $owner;
        }
    	
    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOwner(User $owner) {
        if (false !== $key = array_search(strtoupper($owner), $this->owners, true)) {
            unset($this->owners[$key]);
            $this->owners = array_values($this->owners);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name) {
    	$this->name = $name;
    	
    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
    	return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setNameSlug($nameSlug) {
    	$this->nameSlug = $nameSlug;
    	
    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNameSlug() {
    	return $this->nameSlug;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreators(ArrayCollection $creators) {
    	$this->creators = $creators;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCreators() {
    	return $this->creators;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addCreator(ObjectCreatorInterface $creator) {
        if (!in_array($creator, $this->creators, true)) {
            $this->creators[] = $creator;
        }
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeCreator(ObjectCreatorInterface $creator) {
        if (false !== $key = array_search(strtoupper($creator), $this->creators, true)) {
            unset($this->creators[$key]);
            $this->creators = array_values($this->creators);
        }
        
        return $this;
    }
}