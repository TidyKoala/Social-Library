<?php

namespace SocialLibrary\ReadBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use SocialLibrary\ReadBundle\Entity\Book;
use SocialLibrary\ReadBundle\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadBundle\Entity\Novel
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