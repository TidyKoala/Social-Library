<?php

namespace SocialLibrary\ReadBundle\Entity;

use SocialLibrary\BaseBundle\Entity\Object;
use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;
use SocialLibrary\ReadBundle\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 */
class Book extends Object
{
	/**
	 * @var integer volume
	 */
	protected $volume;
	
	/**
	 * @var \SocialLibrary\ReadBundle\Entity\Serie serie
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
	}

    /**
     * Set volume
     *
     * @param integer $volume
     * @return SocialLibrary\ReadBundle\Entity\Book
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
     * Set serie
     *
     * @param \SocialLibrary\ReadBundle\Entity\Serie $serie
     * @return SocialLibrary\ReadBundle\Entity\Book
     */
    public function setSerie(Serie $serie = null)
    {
        $this->serie = $serie;
    
        return $this;
    }

    /**
     * Get serie
     *
     * @return \SocialLibrary\ReadBundle\Entity\Serie 
     */
    public function getSerie()
    {
        return $this->serie;
    }
	
    /**
     * Set language
     *
     * @param string $language
     * @return SocialLibrary\ReadBundle\Entity\Book
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
     * @return SocialLibrary\ReadBundle\Entity\Book
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
     * @return SocialLibrary\ReadBundle\Entity\Book
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
}
