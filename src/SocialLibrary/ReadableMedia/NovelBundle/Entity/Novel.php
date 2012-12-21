<?php

namespace SocialLibrary\ReadableMedia\NovelBundle\Entity;

use SocialLibrary\BaseBundle\Model\Object;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SocialLibrary\ReadableMedia\NovelBundle\Entity\Novel
 *
 * @ORM\Entity(repositoryClass="SocialLibrary\ReadableMedia\NovelBundle\Entity\NovelRepository")
 * @ORM\Table(name="novel__novel")
 */

class Novel extends Object
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
	 * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinTable(name="novel__owner",
     *      joinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="owner_id", referencedColumnName="id")}
     * )
	 *
	 * @var ArrayCollection owners
	 */
	protected $owners;
	
	/**
	 * @ORM\ManyToMany(targetEntity="SocialLibrary\BaseBundle\Entity\ObjectCreator")
     * @ORM\JoinTable(name="novel__creators",
     *      joinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="creator_id", referencedColumnName="id")}
     * )
	 * 
	 * @var ArrayCollection creators
	 */
	protected $creators;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @Assert\Min(
	 *     limit="1",
	 *     message="volume_under_min",
	 *     invalidMessage="volume_invalid_message"
	 * )
	 * 
	 * @var integer volume
	 */
	protected $volume;
	
	/**
	 * @ORM\ManyToOne(targetEntity="SocialLibrary\ReadableMedia\NovelBundle\Entity\Serie", inversedBy="volumes")
	 * @ORM\JoinColumn(name="serie_id", referencedColumnName="id")
	 * 
	 * @var \SocialLibrary\ReadableMedia\NovelBundle\Entity\Serie serie
	 */
	protected $serie;
	
	/**
	 * @ORM\Column(type="string", length=8, nullable=true)
	 * @Assert\Language(message="language_invalid")
	 */
	protected $language;
	
	/**
	 * @ORM\Column(type="string", length=11, unique=true, nullable=true)
	 * @Assert\Length(
	 *     min="10",
	 *     max="10",
	 *     exactMessage="isbn10_exact_length"
	 * )
	 * 
	 * @var string isbn10
	 */
	protected $isbn10;
	
	/**
	 * @ORM\Column(type="string", length=14, unique=true, nullable=true)
	 * @Assert\Length(
	 *     min="13",
	 *     max="13",
	 *     exactMessage="isbn13_exact_length"
	 * )
	 * 
	 * @var string isbn13
	 */
	protected $isbn13;
	
	
	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getWebPicturePath()
    {
        return parent::getWebPicturePath() . 'readablemedia/novel/';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRootPicturePath()
    {
        return __DIR__ . '/../../../../../web/' . $this->getWebPicturePath();
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return Novel
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    
        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Novel
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isbn10
     *
     * @param string $isbn10
     * @return Novel
     */
    public function setIsbn10($isbn10)
    {
        $this->isbn10 = $isbn10;
    
        return $this;
    }

    /**
     * Get isbn10
     *
     * @return string 
     */
    public function getIsbn10()
    {
        return $this->isbn10;
    }

    /**
     * Set isbn13
     *
     * @param string $isbn13
     * @return Novel
     */
    public function setIsbn13($isbn13)
    {
        $this->isbn13 = $isbn13;
    
        return $this;
    }

    /**
     * Get isbn13
     *
     * @return string 
     */
    public function getIsbn13()
    {
        return $this->isbn13;
    }

    /**
     * Set serie
     *
     * @param \SocialLibrary\ReadableMedia\NovelBundle\Entity\Serie $serie
     * @return Novel
     */
    public function setSerie(\SocialLibrary\ReadableMedia\NovelBundle\Entity\Serie $serie = null)
    {
        $this->serie = $serie;
    
        return $this;
    }

    /**
     * Get serie
     *
     * @return \SocialLibrary\ReadableMedia\NovelBundle\Entity\Serie 
     */
    public function getSerie()
    {
        return $this->serie;
    }
}