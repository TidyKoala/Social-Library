<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Entity;

use SocialLibrary\BaseBundle\Model\Object;
use SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     *      joinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="owner_id", referencedColumnName="id")}
     *      )
	 *
	 * @var ArrayCollection owners
	 */
	protected $owners;
	
	/**
	 * @ORM\ManyToMany(targetEntity="SocialLibrary\BaseBundle\Entity\ObjectCreator")
     * @ORM\JoinTable(name="manga_creators",
     *      joinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="creator_id", referencedColumnName="id")}
     *      )
	 * @Assert\NotNull(message="creators_not_null")
	 * 
	 * @var ArrayCollection creators
	 */
	protected $creators;
	
	/**
	 * @ORM\ManyToMany(targetEntity="SocialLibrary\BaseBundle\Entity\ObjectCreator")
	 * @ORM\JoinTable(name="manga_illustrators",
	 *      joinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="illustrator_id", referencedColumnName="id")}
	 *      )
	 * @Assert\NotNull(message="illustrators_not_null")
	 *
	 * @var ArrayCollection illustrators
	 */
	protected $illustrators;
	
	/**
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank(message="volume_not_blank")
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
	 * @ORM\ManyToOne(targetEntity="SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie", inversedBy="volumes")
	 * @ORM\JoinColumn(name="serie_id", referencedColumnName="id")
	 * @Assert\NotNull(message="serie_not_null")
	 * 
	 * @var ArrayCollection serie
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
	 *     minMessage="isbn10_min_length",
	 *     minMessage="isbn10_max_length",
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
	 *     minMessage="isbn13_min_length",
	 *     minMessage="isbn13_max_length",
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
     * {@inheritdoc}
     */
    public function getWebPicturePath()
    {
        return parent::getWebPicturePath() . 'readablemedia/manga/';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRootPicturePath()
    {
        return __DIR__ . '/../../../../../web/' . $this->getWebPicturePath();
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
        if (!$this->illustrators->contains($illustrator)) {
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
        $this->illustrators->removeElement($illustrator);
        
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