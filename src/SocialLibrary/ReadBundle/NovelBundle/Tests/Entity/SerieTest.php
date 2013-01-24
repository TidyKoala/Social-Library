<?php

namespace SocialLibrary\ReadBundle\NovelBundle\Tests\Entity;

use SocialLibrary\ReadBundle\NovelBundle\Entity\Serie;
use SocialLibrary\ReadBundle\NovelBundle\Entity\Novel;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\ReadBundle\NovelBundle\Tests\Entity\SerieTest
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
        $novel1 = new Novel();
        $novel2 = new Novel();
        $novel3 = new Novel();
        $novel4 = new Novel();
        $arrayCollection = new ArrayCollection();
        
        /* Tests adding volumes */
        $serie->addVolume($novel1);
        $this->assertEquals(1, $serie->getVolumes()->count());
        $serie->addVolume($novel2);
        $this->assertEquals(2, $serie->getVolumes()->count());
        $serie->addVolume($novel3);
        $serie->addVolume($novel4);
        $this->assertEquals(4, $serie->getVolumes()->count());
            /* Tests adding a known volume */
        $serie->addVolume($novel4);
        $this->assertEquals(4, $serie->getVolumes()->count());
        
        /* Tests removing volumes */
        $serie->removeVolume($novel1);
        $this->assertEquals(3, $serie->getVolumes()->count());
        $serie->removeVolume($novel2);
        $serie->removeVolume($novel3);
        $this->assertEquals(1, $serie->getVolumes()->count());
            /* Tests removing an unknown volume */
        $serie->removeVolume($novel3);
        $this->assertEquals(1, $serie->getVolumes()->count());
        
        /* Tests setting volumes */
        $arrayCollection->add($novel1);
        $arrayCollection->add($novel2);
        $arrayCollection->add($novel3);
        $arrayCollection->add($novel4);
        $serie->setVolumes($arrayCollection);
        $this->assertEquals(4, $serie->getVolumes()->count());
    }
}