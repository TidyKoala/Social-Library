<?php

namespace SocialLibrary\BaseBundle\Model;

use Application\Sonata\UserBundle\User;
use SocialLibrary\BaseBundle\Model\ObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\BaseBundle\Model\LendingHistoryInterface
 * 
 */

interface LendingHistoryInterface
{
    /**
     * Set owner
     *
     * @param Application\Sonata\UserBundle\User $owner
     * @return LendingHistoryInterface
     */
    public function setOwner(User $owner);
    
    /**
     * Get owner
     *
     * @return Application\Sonata\UserBundle\User
     */
    public function getOwner();
    
    /**
     * Set borrower
     *
     * @param Application\Sonata\UserBundle\User $borrower
     * @return LendingHistoryInterface
     */
    public function setBorrower(User $borrower);
    
    /**
     * Get borrower
     *
     * @return Application\Sonata\UserBundle\User
     */
    public function getBorrower();
    
    /**
     * Set the object being lent
     * 
     * @param SocialLibrary\BaseBundle\Model\ObjectInterface $object
     * @return LendingHistoryInterface
     */
    public function setObject(ObjectInterface $object);
    
    /**
     * Set the object being lent
     *
     * @return SocialLibrary\BaseBundle\Model\ObjectInterface
     */
    public function getObject();
    
    /**
     * Set date of question to borrow
     * 
     * @param \DateTime $date
     * @return LendingHistoryInterface
     */
    public function setAskedDate(\DateTime $date);
    
    /**
     * Get date of question to borrow
     *
     * @return \DateTime
     */
    public function getAskedDate();
    
    /**
     * Set date of accept to lent
     *
     * @param \DateTime $date
     * @return LendingHistoryInterface
     */
    public function setAcceptedDate(\DateTime $date);
    
    /**
     * Get date of accept to lent
     *
     * @return \DateTime
     */
    public function getAcceptedDate();
    
    /**
     * Set date of cancel to borrow
     *
     * @param \DateTime $date
     * @return LendingHistoryInterface
     */
    public function setCanceledDate(\DateTime $date);
    
    /**
     * Get date of cancel to borrow
     *
     * @return \DateTime
     */
    public function getCanceledDate();
    
    /**
     * Set date of refuse to lent
     *
     * @param \DateTime $date
     * @return LendingHistoryInterface
     */
    public function setRefusedDate(\DateTime $date);
    
    /**
     * Get date of refuse to lent
     *
     * @return \DateTime
     */
    public function getRefusedDate();
    
    /**
     * Set date of borrow
     *
     * @param \DateTime $date
     * @return LendingHistoryInterface
     */
    public function setLentDate(\DateTime $date);
    
    /**
     * Get date of borrow
     *
     * @return \DateTime
     */
    public function getLentDate();
    
    /**
     * Set date of return of lent object
     *
     * @param \DateTime $date
     * @return LendingHistoryInterface
     */
    public function setReturnedDate(\DateTime $date);
    
    /**
     * Get date of return of lent object
     *
     * @return \DateTime
     */
    public function getReturnedDate();
}