<?php

namespace Acme\DemoBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Doctrine\ORM\Mapping as ORM; // doctrine orm annotations

/**
 * @ORM\Entity
 */
class BlogArticle
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(length=64)
     */
    private $title;
    
    /**
     * @ORM\Column(length=64)
     * @Gedmo\Slug(fields={"title"}, updatable=true, separator="_")
     */
    private $titleSlug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;
    
    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitleSlug($titleSlug)
    {
        $this->titleSlug = $titleSlug;
    }

    public function getTitleSlug()
    {
        return $this->titleSlug;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setContent($content)
    {
        return $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}