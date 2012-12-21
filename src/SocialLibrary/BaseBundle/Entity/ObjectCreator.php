<?php

namespace SocialLibrary\BaseBundle\Entity;

use SocialLibrary\BaseBundle\Model\ObjectCreator as BaseObjectCreator;

/**
 * SocialLibrary\BaseBundle\Entity\ObjectCreator
 * 
 */
class ObjectCreator extends BaseObjectCreator
{
	/**
	 * @var integer id
	 */
	protected $id;
	
	
	/**
     * {@inheritdoc}
	 */
	public function getId() 
	{
		return $this->id;
	}
}