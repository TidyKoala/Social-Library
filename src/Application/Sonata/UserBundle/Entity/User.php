<?php
/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * This file has been generated by the Sonata EasyExtends bundle ( http://sonata-project.org/easy-extends )
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author theWholeLifeToLearn thewholelifetolearn@gmail.com
 */
class User extends BaseUser
{

    /**
     * @var integer $id
     */
    protected $id;
	
	/**
	 * @var string
	 */
	protected $address;
	
	/**
	 * @var string
	 */
	protected $addressComplementary;
	
	/**
	 * @var string
	 */
	protected $postalCode;
	
	/**
	 * @var string
	 */
	protected $town;
	
	/**
	 * @var string
	 */
	protected $country;
	
	/**
	 * @var Collection
	 */
	protected $friends;
	
	/**
	 * @var Collection
	 */
	protected $friendsOf;
	

    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
        $this->friends = new \Doctrine\Common\Collections\ArrayCollection();
        $this->friendsOf = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Set addressComplementary
     *
     * @param string $addressComplementary
     * @return User
     */
    public function setAddressComplementary($addressComplementary)
    {
        $this->addressComplementary = $addressComplementary;
    
        return $this;
    }

    /**
     * Get addressComplementary
     *
     * @return string 
     */
    public function getAddressComplementary()
    {
        return $this->addressComplementary;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return User
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return User
     */
    public function setTown($town)
    {
        $this->town = $town;
    
        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add friends
     *
     * @param \Application\Sonata\UserBundle\Entity\User $friends
     * @return User
     */
    public function addFriend(\Application\Sonata\UserBundle\Entity\User $friends)
    {
        $this->friends[] = $friends;
    
        return $this;
    }

    /**
     * Remove friends
     *
     * @param \Application\Sonata\UserBundle\Entity\User $friends
     */
    public function removeFriend(\Application\Sonata\UserBundle\Entity\User $friends)
    {
        $this->friends->removeElement($friends);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Add friendsOf
     *
     * @param \Application\Sonata\UserBundle\Entity\User $friendsOf
     * @return User
     */
    public function addFriendsOf(\Application\Sonata\UserBundle\Entity\User $friendsOf)
    {
        $this->friendsOf[] = $friendsOf;
    
        return $this;
    }

    /**
     * Remove friendsOf
     *
     * @param \Application\Sonata\UserBundle\Entity\User $friendsOf
     */
    public function removeFriendsOf(\Application\Sonata\UserBundle\Entity\User $friendsOf)
    {
        $this->friendsOf->removeElement($friendsOf);
    }

    /**
     * Get friendsOf
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriendsOf()
    {
        return $this->friendsOf;
    }
}