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
	 * @var ObjectCreatorInterface creator
	 */
	protected $creator;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		
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
    public function setCreator(ObjectCreatorInterface $creator) {
    	$this->creator = $creator;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCreator() {
    	return $this->creator;
    }
}