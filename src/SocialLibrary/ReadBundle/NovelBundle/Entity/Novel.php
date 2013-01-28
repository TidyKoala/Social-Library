<?php

namespace SocialLibrary\ReadBundle\NovelBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use SocialLibrary\ReadBundle\CommonBundle\Entity\Book;
use SocialLibrary\ReadBundle\CommonBundle\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadBundle\NovelBundle\Entity\Novel
 * 
 */

class Novel extends Book
{
    /**
     * @var integer id
     */
	protected $id;
	
	
	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct();
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
}