<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Entity;

use SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie
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
	 * @var Doctrine\Common\Collections\ArrayCollection volumes
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
     * @return SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie
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
     * @return SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie
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
     * Set one or more volumes. Deletes the present ones
     *
	 * @param Doctrine\Common\Collections\ArrayCollection volumes
     * @return SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie
     */
    public function setVolumes(ArrayCollection $volumes)
    {
        $this->volumes = $volumes;
        
        return $this;
    }

    /**
     * Get volumes
     *
     * @return Doctrine\Common\Collections\ArrayCollection 
     */
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * Add a volume
     *
     * @param SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga $volumes
     * @return SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie
     */
    public function addVolume(Manga $volume)
    {
        if(!$this->volumes->contains($volume)) {
            $this->volumes[] = $volume;
        }
    
        return $this;
    }

    /**
     * Remove a volume
     *
     * @param SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga $volumes
     */
    public function removeVolume(Manga $volume)
    {
        $this->volumes->removeElement($volume);
    }
}