<?php

namespace SocialLibrary\ReadBundle\MangaBundle\Tests\Entity;

use SocialLibrary\BaseBundle\Entity\ObjectCreator;
use SocialLibrary\ReadBundle\MangaBundle\Entity\Manga;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadBundle\MangaBundle\Tests\Entity\MangaTest
 * 
 */
class MangaTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Tests all functions related to the illustrators: setIllustrators(), getIllustrators(), addIllustrator(), removeIllustrator()
     */
    public function testIllustrators()
    {
        $manga = new Manga();
        $illustrator1 = new ObjectCreator();
        $illustrator2 = new ObjectCreator();
        $illustrator3 = new ObjectCreator();
        $illustrator4 = new ObjectCreator();
        $illustrator5 = new ObjectCreator();
        $arrayCollection = new ArrayCollection();
        
        /* Tests adding illustrators */
        $manga->addIllustrator($illustrator1);
        $this->assertEquals(1, $manga->getIllustrators()->count());
        $manga->addIllustrator($illustrator2);
        $this->assertEquals(2, $manga->getIllustrators()->count());
        $manga->addIllustrator($illustrator3);
        $manga->addIllustrator($illustrator4);
        $this->assertEquals(4, $manga->getIllustrators()->count());
            /* Tests adding a known illustrator */
        $manga->addIllustrator($illustrator1);
        $this->assertEquals(4, $manga->getIllustrators()->count());
        
        /* Tests removing illustrators */
        $manga->removeIllustrator($illustrator1);
        $this->assertEquals(3, $manga->getIllustrators()->count());
        $manga->removeIllustrator($illustrator2);
        $manga->removeIllustrator($illustrator3);
        $this->assertEquals(1, $manga->getIllustrators()->count());
            /* Tests removing unknown illustrator */
        $manga->removeIllustrator($illustrator1);
        $this->assertEquals(1, $manga->getIllustrators()->count());
        
        /* Tests setting illustrators */
        $arrayCollection->add($illustrator1);
        $arrayCollection->add($illustrator2);
        $arrayCollection->add($illustrator3);
        $arrayCollection->add($illustrator4);
        $manga->setIllustrators($arrayCollection);
        $this->assertEquals(4, $manga->getIllustrators()->count());
    }
}