<?php

namespace SocialLibrary\BaseBundle\Model;

use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * SocialLibrary\BaseBundle\Model\ObjectCreator
 * 
 */
abstract class ObjectCreator implements ObjectCreatorInterface
{
	/**
	 * @ORM\Column(type="string")
	 * 
	 * @var string firstname
	 */
	protected $firstname;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 *
	 * @var string lastname
	 */
	protected $lastname;
	
	/**
	 * @ORM\Column(type="string", name="name_slug")
	 * @Gedmo\Slug(fields={"firstname","lastname"})
	 * 
	 * @var string nameSlug
	 */
	protected $nameSlug;
	
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->getFullname();
	}
	
	/**
     * {@inheritdoc}
	 */
	public function setFirstname($firstname) 
	{
		$this->firstname = $firstname;
		
		return $this;
	}
	
	/**
     * {@inheritdoc}
	 */
	public function getFirstname() 
	{
		return $this->firstname;
	}
	
	/**
     * {@inheritdoc}
	 */
	public function setLastname($lastname) 
	{
		$this->lastname = strtoupper($lastname);
		
		return $this;
	}
	
	/**
     * {@inheritdoc}
	 */
	public function getLastname() 
	{
		return $this->lastname;
	}
	
	/**
     * {@inheritdoc}
	 */
	public function getFullname() 
	{
		return sprintf("%s %s", $this->getFirstname(), $this->getLastname());
	}
	
	/**
     * {@inheritdoc}
	 */
	public function getNameSlug() 
	{
		return $this->nameSlug;
	}
}