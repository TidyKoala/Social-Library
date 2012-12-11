<?php

namespace SocialLibrary\BaseBundle\Model;

use Application\Sonata\UserBundle\Entity\User;
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
     * Returns TRUE if user is owner of object
     *
     * @param Application\Sonata\UserBundle\User $owner
     * @return boolean 
     */
    public function isOwner(User $owner);

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
     * Set filename of the picture
     * 
     * @param string $picture
     * @return ObjectInterface
     */
    public function setPicture($picture);
    
    /**
     * Returns filename of the picture
     * 
     * @return string
     */
    public function getPicture();
    
    /**
     * Set the file object
     * 
     * @return ObjectInterface
     */
    public function setPictureFile($pictureFile);
    
    /**
     * Returns the file object
     * 
     * @return string
     */
    public function getPictureFile();
    
    /**
     * Returns the path of the picture relative to the web directory
     * 
     * @return string
     */
    public function getWebPicturePath();
    
    /**
     * Returns the path of the picture relative to the root directory
     * 
     * @return string
     */
    public function getRootPicturePath();
    
    /**
     * Uploads the picture
     * 
     * @return ObjectInterface
     */
    public function upload();
    
    /**
     * Set one or more creators
     * 
     * @param ArrayCollection $creators
     */
    public function setCreators(ArrayCollection $creators);
    
    /**
     * Get creators
     * 
     * @return ArrayCollection
     */
    public function getCreators();
    
    /**
     * Add a creator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $creator
     */
    public function addCreator(ObjectCreatorInterface $creator);
    
    /**
     * Remove a creator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $creator
     */
    public function removeCreator(ObjectCreatorInterface $creator);
}