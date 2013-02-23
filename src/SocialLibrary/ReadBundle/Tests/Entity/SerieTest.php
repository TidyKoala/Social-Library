<?php

namespace SocialLibrary\ReadBundle\Tests\Entity;

use SocialLibrary\ReadBundle\Entity\Serie;
use SocialLibrary\ReadBundle\MangaBundle\Entity\Manga;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadBundle\Tests\Entity\SerieTest
 * 
 */
class SerieTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Tests all functions related to volumes: setVolumes(), getVolumes(), addVolume(), removeVolume()
     */
    public function testVolumes()
    {
        $serie = new Serie();
        $manga1 = new Manga();
        $manga2 = new Manga();
        $manga3 = new Manga();
        $manga4 = new Manga();
        $arrayCollection = new ArrayCollection();
        
        /* Tests adding volumes */
        $serie->addVolume($manga1);
        $this->assertEquals(1, $serie->getVolumes()->count());
        $serie->addVolume($manga2);
        $this->assertEquals(2, $serie->getVolumes()->count());
        $serie->addVolume($manga3);
        $serie->addVolume($manga4);
        $this->assertEquals(4, $serie->getVolumes()->count());
            /* Tests adding a known volume */
        $serie->addVolume($manga4);
        $this->assertEquals(4, $serie->getVolumes()->count());
        
        /* Tests removing volumes */
        $serie->removeVolume($manga1);
        $this->assertEquals(3, $serie->getVolumes()->count());
        $serie->removeVolume($manga2);
        $serie->removeVolume($manga3);
        $this->assertEquals(1, $serie->getVolumes()->count());
            /* Tests removing an unknown volume */
        $serie->removeVolume($manga3);
        $this->assertEquals(1, $serie->getVolumes()->count());
        
        /* Tests setting volumes */
        $arrayCollection->add($manga1);
        $arrayCollection->add($manga2);
        $arrayCollection->add($manga3);
        $arrayCollection->add($manga4);
        $serie->setVolumes($arrayCollection);
        $this->assertEquals(4, $serie->getVolumes()->count());
    }
}
