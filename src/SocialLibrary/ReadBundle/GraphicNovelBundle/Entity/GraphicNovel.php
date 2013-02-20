<?php
namespace SocialLibrary\ReadBundle\GraphicNovelBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use SocialLibrary\ReadBundle\CommonBundle\Entity\Book;
use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;

/**
 * 
 *
 */
class GraphicNovel extends Book
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
     * @return SocialLibrary\ReadBundle\GraphicNovelBundle\Entity\GraphicNovel
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
     * @return SocialLibrary\ReadBundle\GraphicNovelBundle\Entity\GraphicNovel
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
     * @return SocialLibrary\ReadBundle\GraphicNovelBundle\Entity\GraphicNovel
     */
    public function removeIllustrator(ObjectCreatorInterface $illustrator) {
        $this->illustrators->removeElement($illustrator);
        
        return $this;
    }

}
