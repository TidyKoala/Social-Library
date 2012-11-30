<?php

namespace SocialLibrary\BaseBundle\Model;

use Application\Sonata\UserBundle\User;
use SocialLibrary\BaseBundle\Model\ObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SocialLibrary\BaseBundle\Model\LendingHistory
 * 
 */

abstract class LendingHistory implements LendingHistoryInterface
{
	/**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * 
     * @var User owner
	 */
	protected $owner;
	
	/**
	 * @ORM\OneToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="borrower_id", referencedColumnName="id")
     * 
     * @var User borrower
	 */
	protected $borrower;
	
	/**
     * @var ObjectInterface object
	 */
	protected $object;
	
	/**
	 * @ORM\Column(type="datetime", name="asked_date")
	 * 
	 * @var \DateTime askedDate
	 */
	protected $askedDate;
	
	/**
	 * @ORM\Column(type="datetime", name="accepted_date", nullable=true)
	 *
	 * @var \DateTime acceptedDate
	 */
	protected $acceptedDate;
	
	/**
	 * @ORM\Column(type="datetime", name="canceled_date", nullable=true)
	 *
	 * @var \DateTime canceledDate
	 */
	protected $canceledDate;
	
	/**
	 * @ORM\Column(type="datetime", name="refused_date", nullable=true)
	 *
	 * @var \DateTime refusedDate
	 */
	protected $refusedDate;
	
	/**
	 * @ORM\Column(type="datetime", name="lent_date", nullable=true)
	 *
	 * @var \DateTime lentDate
	 */
	protected $lentDate;
	
	/**
	 * @ORM\Column(type="datetime", name="returned_date", nullable=true)
	 *
	 * @var \DateTime returnedDate
	 */
	protected $returnedDate;
	
	
    /**
     * {@inheritdoc}
     */
    public function setOwner(User $owner) {
    	$this->owner = $owner;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOwner() {
    	return $this->owner;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBorrower(User $borrower){
    	$this->borrower = $borrower;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBorrower(){
    	return $this->borrower;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setObject(ObjectInterface $object) {
    	$this->object = $object;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getObject() {
    	return $this->object;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setAskedDate(\DateTime $date = null) {
    	if(empty($date)) {
    		$date = new DateTime();
    	}
    	$this->askedDate = $date;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAskedDate() {
    	return $this->askedDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setAcceptedDate(\DateTime $date) {
    	if(empty($date)) {
    		$date = new DateTime();
    	}
    	$this->acceptedDate = $date;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAcceptedDate() {
    	return $this->acceptedDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCanceledDate(\DateTime $date) {
    	if(empty($date)) {
    		$date = new DateTime();
    	}
    	$this->canceledDate = $date;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCanceledDate() {
    	return $this->canceledDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRefusedDate(\DateTime $date) {
    	if(empty($date)) {
    		$date = new DateTime();
    	}
    	$this->refusedDate = $date;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRefusedDate() {
    	return $this->refusedDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLentDate(\DateTime $date) {
    	if(empty($date)) {
    		$date = new DateTime();
    	}
    	$this->lentDate = $date;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLentDate() {
    	return $this->lentDate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReturnedDate(\DateTime $date) {
    	if(empty($date)) {
    		$date = new DateTime();
    	}
    	$this->returnedDate = $date;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReturnedDate() {
    	return $this->returnedDate;
    }
}