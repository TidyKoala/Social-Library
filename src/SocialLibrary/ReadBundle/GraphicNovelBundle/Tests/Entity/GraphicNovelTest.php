<?php

namespace SocialLibrary\ReadBundle\GraphicNovelBundle\Tests\Entity;

use SocialLibrary\BaseBundle\Entity\ObjectCreator;
use SocialLibrary\ReadBundle\GraphicNovelBundle\Entity\GraphicNovel;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadBundle\MangaBundle\Tests\Entity\MangaTest
 * 
 */
class GraphicNovelTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Tests all functions related to the illustrators: setIllustrators(), getIllustrators(), addIllustrator(), removeIllustrator()
     */
    public function testIllustrators()
    {
        $graphicNovel = new GraphicNovel();
        $illustrator1 = new ObjectCreator();
        $illustrator2 = new ObjectCreator();
        $illustrator3 = new ObjectCreator();
        $illustrator4 = new ObjectCreator();
        $illustrator5 = new ObjectCreator();
        $arrayCollection = new ArrayCollection();
        
        /* Tests adding illustrators */
        $graphicNovel->addIllustrator($illustrator1);
        $this->assertEquals(1, $graphicNovel->getIllustrators()->count());
        $graphicNovel->addIllustrator($illustrator2);
        $this->assertEquals(2, $graphicNovel->getIllustrators()->count());
        $graphicNovel->addIllustrator($illustrator3);
        $graphicNovel->addIllustrator($illustrator4);
        $this->assertEquals(4, $graphicNovel->getIllustrators()->count());
            /* Tests adding a known illustrator */
        $graphicNovel->addIllustrator($illustrator1);
        $this->assertEquals(4, $graphicNovel->getIllustrators()->count());
        
        /* Tests removing illustrators */
        $graphicNovel->removeIllustrator($illustrator1);
        $this->assertEquals(3, $graphicNovel->getIllustrators()->count());
        $graphicNovel->removeIllustrator($illustrator2);
        $graphicNovel->removeIllustrator($illustrator3);
        $this->assertEquals(1, $graphicNovel->getIllustrators()->count());
            /* Tests removing unknown illustrator */
        $graphicNovel->removeIllustrator($illustrator1);
        $this->assertEquals(1, $graphicNovel->getIllustrators()->count());
        
        /* Tests setting illustrators */
        $arrayCollection->add($illustrator1);
        $arrayCollection->add($illustrator2);
        $arrayCollection->add($illustrator3);
        $arrayCollection->add($illustrator4);
        $graphicNovel->setIllustrators($arrayCollection);
        $this->assertEquals(4, $graphicNovel->getIllustrators()->count());
    }
}