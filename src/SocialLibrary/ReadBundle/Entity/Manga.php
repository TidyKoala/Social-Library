<?php

namespace SocialLibrary\ReadBundle\Entity;

use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;
use SocialLibrary\ReadBundle\Entity\Book;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 */
class Manga extends Book
{
    /**
     * @var integer id
     */
	protected $id;
	
	/**
	 * @var ArrayCollection illustrators
	 */
	protected $illustrators;
	
	
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
     * @return SocialLibrary\ReadBundle\Entity\Manga
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
     * @param SocialLibrary\BaseBundle\Model\ObjectCreatorInterface $illustrator
     * @return SocialLibrary\ReadBundle\Entity\Manga
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
     * @param SocialLibrary\BaseBundle\Model\ObjectCreatorInterface $illustrator
     * @return SocialLibrary\ReadBundle\Entity\Manga
     */
    public function removeIllustrator(ObjectCreatorInterface $illustrator) {
        $this->illustrators->removeElement($illustrator);
        
        return $this;
    }
}