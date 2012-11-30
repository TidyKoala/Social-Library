<?php

namespace SocialLibrary\BaseBundle\Model;

use Application\Sonata\UserBundle\User;
use SocialLibrary\BaseBundle\Model\ObjectCreatorInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\BaseBundle\Model\ObjectInterface
 * 
 */

interface ObjectInterface
{
	/**
	 * Set an array of owners
	 * 
	 * @param ArrayCollection $owners
	 * @return ObjectInterface
	 */
	public function setOwners(ArrayCollection $owners);
	
    /**
     * Get owners
     *
     * @return Collection
     */
    public function getOwners();

    /**
     * Add owner
     *
     * @param Application\Sonata\UserBundle\User $owner
     * @return ObjectInterface 
     */
    public function addOwner(User $owner);

    /**
     * Remove owner
     *
     * @param Application\Sonata\UserBundle\User $owner
     * @return ObjectInterface 
     */
    public function removeOwner(User $owner);

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set name sluggified
     *
     * @param string $name
     */
    public function setNameSlug($nameSlug);

    /**
     * Get name sluggified
     *
     * @return string 
     */
    public function getNameSlug();
    
    /**
     * Set a creator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $creator
     */
    public function setCreator(ObjectCreatorInterface $creator);
    
    /**
     * Get  creator
     * 
     * @return SocialLibrary\BaseBundle\ObjectCreatorInterface
     */
    public function getCreator();
}