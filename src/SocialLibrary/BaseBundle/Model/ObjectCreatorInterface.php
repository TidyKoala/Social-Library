<?php

namespace SocialLibrary\BaseBundle\Model;

/**
 * SocialLibrary\BaseBundle\Model\ObjectCreatorInterface
 * 
 */
interface ObjectCreatorInterface
{
	/**
	 * Set firstname of the creator of the object
	 * 
	 * @param string $name
	 * @return ObjectCreatorInterface
	 */
	public function setFirstname($firstname);
	
	/**
	 * Return the name of the creator of the object
	 * 
	 * @return string
	 */
	public function getFirstname();
	
	/**
	 * Set lastname of the creator of the object
	 * 
	 * @param string $lastname
	 * @return ObjectCreatorInterface
	 */
	public function setLastname($lastname);
	
	/**
	 * Returns the lastname of the creator of the object
	 * 
	 * @return string
	 */
	public function getLastname();
	
	/**
	 * Returns the fullname of the creator of the object
	 * 
	 * @return string
	 */
	public function getFullname();
	
	/**
	 * Returns the name sluggified of the creator of the object
	 *
	 * @return string
	 */
	public function getNameSlug();
	
	/**
	 * Returns the complete name of the creator
	 * 
	 * @return string
	 */
	public function __toString();
}