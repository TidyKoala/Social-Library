<?php

namespace SocialLibrary\BaseBundle\Model;

use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * SocialLibrary\BaseBundle\Model\ObjectCreator
 * 
 */
abstract class ObjectCreator implements ObjectCreatorInterface
{
	/**
	 * @var string firstname
	 */
	protected $firstname;
	
	/**
	 * @var string lastname
	 */
	protected $lastname;
	
	/**
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