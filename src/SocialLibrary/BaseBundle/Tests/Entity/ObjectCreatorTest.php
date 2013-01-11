<?php

namespace SocialLibrary\BaseBundle\Tests\Entity;

use SocialLibrary\BaseBundle\Entity\ObjectCreator;

/**
 * SocialLibrary\BaseBundle\Tests\Entity\ObjectCreatorTest
 * 
 */

class ObjectCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testLastname()
    {
        $objectCreator = $this->getObjectCreator();
        $this->assertNull($objectCreator->getLastname());
        
        $objectCreator->setLastname('foobar');
        $this->assertEquals('FOOBAR', $objectCreator->getLastname());
        $objectCreator->setLastname('Foobar');
        $this->assertEquals('FOOBAR', $objectCreator->getLastname());
        $objectCreator->setLastname('fooBar');
        $this->assertEquals('FOOBAR', $objectCreator->getLastname());
        $objectCreator->setLastname('FooBar');
        $this->assertEquals('FOOBAR', $objectCreator->getLastname());
        $objectCreator->setLastname('foo bar');
        $this->assertEquals('FOO BAR', $objectCreator->getLastname());
        $objectCreator->setLastname('foo Bar');
        $this->assertEquals('FOO BAR', $objectCreator->getLastname());
    }
    
    public function testFullname()
    {
        $objectCreator = $this->getObjectCreator();
        $this->assertEquals(' ', $objectCreator->getFullname());
        
        $objectCreator->setFirstname('foofoo');
        $this->assertEquals('foofoo ', $objectCreator->getFullname());
        $objectCreator->setLastname('foobar');
        $this->assertEquals('foofoo FOOBAR', $objectCreator->getFullname());
    }
    
    public function testToString()
    {
        $objectCreator = $this->getObjectCreator();
        $this->assertEquals(' ', $objectCreator);
        
        $objectCreator->setFirstname('foofoo');
        $objectCreator->setLastname('foobar');
        $this->assertEquals($objectCreator->getFullname(), $objectCreator);
    }
    
    /**
     * Creates a mock of SocialLibrary\BaseBundle\Entity\ObjectCreator
     * 
     * @return SocialLibrary\BaseBundle\Entity\ObjectCreator
     */
    protected function getObjectCreator()
    {
        return $this->getMockForAbstractClass('SocialLibrary\BaseBundle\Entity\ObjectCreator');
    }
}