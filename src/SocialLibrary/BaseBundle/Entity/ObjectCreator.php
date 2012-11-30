<?php

namespace SocialLibrary\BaseBundle\Entity;

use SocialLibrary\BaseBundle\Model\ObjectCreator as BaseObjectCreator;
use Doctrine\ORM\Mapping as ORM;


/**
 * SocialLibrary\BaseBundle\Entity\ObjectCreator
 * 
 * @ORM\Entity
 * @ORM\Table(name="object_creator")
 */
class ObjectCreator extends BaseObjectCreator
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
	 * 
	 * @var integer id
	 */
	protected $id;
	
	
	/**
     * {@inheritdoc}
	 */
	public function getId() {
		return $this->id;
	}
}