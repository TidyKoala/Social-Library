<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Entity;

use SocialLibrary\BaseBundle\Model\Object;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie
 * 
 * @ORM\Entity
 * @ORM\Table(name="serie")
 */
class Serie
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
	 * @ORM\Column(type="string")
	 *
	 * @var string name
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", name="name_slug")
	 * @Gedmo\Slug(fields={"name"}, unique=true, separator="-", updatable=true)
	 *
	 * @var string nameSlug
	 */
	protected $nameSlug;
	
	/**
	 * @ORM\OneToMany(targetEntity="Manga", mappedBy="serie")
	 * 
	 * @var ArrayCollection volumes
	 */
	protected $volumes;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->volumes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Serie
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameSlug
     *
     * @param string $nameSlug
     * @return Serie
     */
    public function setNameSlug($nameSlug)
    {
        $this->nameSlug = $nameSlug;
    
        return $this;
    }

    /**
     * Get nameSlug
     *
     * @return string 
     */
    public function getNameSlug()
    {
        return $this->nameSlug;
    }

    /**
     * Add volumes
     *
     * @param \SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga $volumes
     * @return Serie
     */
    public function addVolume(\SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga $volumes)
    {
        $this->volumes[] = $volumes;
    
        return $this;
    }

    /**
     * Remove volumes
     *
     * @param \SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga $volumes
     */
    public function removeVolume(\SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga $volumes)
    {
        $this->volumes->removeElement($volumes);
    }

    /**
     * Get volumes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVolumes()
    {
        return $this->volumes;
    }
}