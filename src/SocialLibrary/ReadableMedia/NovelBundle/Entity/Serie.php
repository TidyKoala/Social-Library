<?php

namespace SocialLibrary\ReadableMedia\NovelBundle\Entity;

use SocialLibrary\BaseBundle\Model\Object;
use SocialLibrary\ReadableMedia\NovelBundle\Entity\Novel;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SocialLibrary\ReadableMedia\NovelBundle\Entity\Serie
 * 
 */
class Serie
{
    /**
     * @var integer id
     */
	protected $id;
	
	/**
	 * @var string name
	 */
	protected $name;
	
	/**
	 * @var string nameSlug
	 */
	protected $nameSlug;
	
	/**
	 * @var ArrayCollection volumes
	 */
	protected $volumes;
	
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->volumes = new ArrayCollection();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return $this->getName();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Serie
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameSlug
     *
     * @param string $nameSlug
     * @return Serie
     */
    public function setNameSlug($nameSlug)
    {
        $this->nameSlug = $nameSlug;
    
        return $this;
    }

    /**
     * Get nameSlug
     *
     * @return string 
     */
    public function getNameSlug()
    {
        return $this->nameSlug;
    }

    /**
     * Add volumes
     *
     * @param \SocialLibrary\ReadableMedia\NovelBundle\Entity\Novel $volumes
     * @return Serie
     */
    public function addVolume(Novel $volumes)
    {
        $this->volumes[] = $volumes;
    
        return $this;
    }

    /**
     * Remove volumes
     *
     * @param \SocialLibrary\ReadableMedia\NovelBundle\Entity\Novel $volumes
     */
    public function removeVolume(Novel $volumes)
    {
        $this->volumes->removeElement($volumes);
    }

    /**
     * Get volumes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVolumes()
    {
        return $this->volumes;
    }
}