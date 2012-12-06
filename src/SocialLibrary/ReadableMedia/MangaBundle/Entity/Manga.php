<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Entity;

use SocialLibrary\BaseBundle\Model\Object;
use SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga
 * 
 * @ORM\Entity(repositoryClass="SocialLibrary\ReadableMedia\MangaBundle\Entity\MangaRepository")
 * @ORM\Table(name="manga")
 */

class Manga extends Object
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
     * @ORM\JoinTable(name="manga_owner",
     *      joinColumns={@ORM\JoinColumn(name="owner_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")}
     *      )
	 *
	 * @var ArrayCollection creators
	 */
	protected $owners;
	
	/**
	 * @ORM\ManyToMany(targetEntity="SocialLibrary\BaseBundle\Entity\ObjectCreator")
     * @ORM\JoinTable(name="manga_creators",
     *      joinColumns={@ORM\JoinColumn(name="creator_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")}
     *      )
	 *
	 * @var ArrayCollection creators
	 */
	protected $creators;
	
	/**
	 * @ORM\ManyToMany(targetEntity="SocialLibrary\BaseBundle\Entity\ObjectCreator")
	 * @ORM\JoinTable(name="manga_illustrators",
	 *      joinColumns={@ORM\JoinColumn(name="illustrator_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")}
	 *      )
	 *
	 * @var ArrayCollection illustrators
	 */
	protected $illustrators;
	
	/**
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer volume
	 */
	protected $volume;
	
	/**
	 * @ORM\ManyToOne(targetEntity="SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie", inversedBy="volumes")
	 * @ORM\JoinColumn(name="serie_id", referencedColumnName="id")
	 * 
	 * @var ArrayCollection serie
	 */
	protected $serie;
	
	/**
	 * @ORM\Column(type="string", length=8, nullable=true)
	 */
	protected $language;
	
	/**
	 * @ORM\Column(type="string", length=11, unique=true, nullable=true)
	 */
	protected $isbn10;
	
	/**
	 * @ORM\Column(type="string", length=14, unique=true, nullable=true)
	 */
	protected $isbn13;
	
	
	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->illustrators = new ArrayCollection();
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
     * Set one or more illustrators
     * 
     * @param ArrayCollection $illustrators
     */
    public function setIllustrators(ArrayCollection $illustrators) {
    	$this->illustrators = $illustrators;
    	
    	return $this;
    }
    
    /**
     * Get illustrators
     * 
     * @return ArrayCollection
     */
    public function getIllustrators() {
    	return $this->illustrators;
    }
    
    /**
     * Add an illustrator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $illustrator
     */
    public function addIllustrator(ObjectCreatorInterface $illustrator) {
        if (!in_array($illustrator, $this->illustrators, true)) {
            $this->illustrators[] = $illustrator;
        }
    	
    	return $this;
    }
    
    /**
     * Remove an illustrator
     * 
     * @param SocialLibrary\BaseBundle\ObjectCreatorInterface $illustrator
     */
    public function removeIllustrator(ObjectCreatorInterface $illustrator) {
        if (false !== $key = array_search(strtoupper($illustrator), $this->illustrators, true)) {
            unset($this->illustrators[$key]);
            $this->illustrators = array_values($this->illustrators);
        }
        
        return $this;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return Manga
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
     * @return Manga
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
     * @return Manga
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
     * @return Manga
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
     * @param \SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie $serie
     * @return Manga
     */
    public function setSerie(Serie $serie = null)
    {
        $this->serie = $serie;
    
        return $this;
    }

    /**
     * Get serie
     *
     * @return \SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie 
     */
    public function getSerie()
    {
        return $this->serie;
    }
}