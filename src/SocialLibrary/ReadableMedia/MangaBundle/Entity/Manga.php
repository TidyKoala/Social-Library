<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Entity;

use SocialLibrary\BaseBundle\Entity\Object;
use SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga
 * 
 */

class Manga extends Object
{
    /**
     * @var integer id
     */
	protected $id;
	
	/**
	 * @var ArrayCollection owners
	 */
	protected $owners;
	
	/**
	 * @var ArrayCollection creators
	 */
	protected $creators;
	
	/**
	 * @var ArrayCollection illustrators
	 */
	protected $illustrators;
	
	/**
	 * @var integer volume
	 */
	protected $volume;
	
	/**
	 * @var \SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie serie
	 */
	protected $serie;
	
	/**
	 * @var string language
	 */
	protected $language;
	
	/**
	 * @var string isbn10
	 */
	protected $isbn10;
	
	/**
	 * @var string isbn13
	 */
	protected $isbn13;
	
	
	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->illustrators = new ArrayCollection();
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
     * Set one or more illustrators
     * 
     * @param ArrayCollection $illustrators
     */
    public function setIllustrators(ArrayCollection $illustrators) {
    	$this->illustrators = $illustrators;
    	
    	return $this;
    }
    
    /**
     * Get illustrators
     * 
     * @return ArrayCollection
     */
    public function getIllustrators() {
    	return $this->illustrators;
    }
    
    /**
     * Add an illustrator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $illustrator
     */
    public function addIllustrator(ObjectCreatorInterface $illustrator) {
        if (!$this->illustrators->contains($illustrator)) {
            $this->illustrators[] = $illustrator;
        }
    	
    	return $this;
    }
    
    /**
     * Remove an illustrator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $illustrator
     */
    public function removeIllustrator(ObjectCreatorInterface $illustrator) {
        $this->illustrators->removeElement($illustrator);
        
        return $this;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return Manga
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    
        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Manga
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isbn10
     *
     * @param string $isbn10
     * @return Manga
     */
    public function setIsbn10($isbn10)
    {
        $this->isbn10 = $isbn10;
    
        return $this;
    }

    /**
     * Get isbn10
     *
     * @return string 
     */
    public function getIsbn10()
    {
        return $this->isbn10;
    }

    /**
     * Set isbn13
     *
     * @param string $isbn13
     * @return Manga
     */
    public function setIsbn13($isbn13)
    {
        $this->isbn13 = $isbn13;
    
        return $this;
    }

    /**
     * Get isbn13
     *
     * @return string 
     */
    public function getIsbn13()
    {
        return $this->isbn13;
    }

    /**
     * Set serie
     *
     * @param \SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie $serie
     * @return Manga
     */
    public function setSerie(Serie $serie = null)
    {
        $this->serie = $serie;
    
        return $this;
    }

    /**
     * Get serie
     *
     * @return \SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie 
     */
    public function getSerie()
    {
        return $this->serie;
    }
}