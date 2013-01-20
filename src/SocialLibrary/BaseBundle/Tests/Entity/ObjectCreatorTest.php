<?php

namespace SocialLibrary\BaseBundle\Tests\Entity;

use SocialLibrary\BaseBundle\Entity\ObjectCreator;

/**
 * SocialLibrary\BaseBundle\Tests\Entity\ObjectCreatorTest
 * 
 */
class ObjectCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Creates an object of SocialLibrary\BaseBundle\Entity\ObjectCreator
     * 
     * @return SocialLibrary\BaseBundle\Entity\ObjectCreator
     */
    public function getObjectCreator()
    {
        return new ObjectCreator();
    }
    
    public function getLastnames()
    {
        return array(
            array('foobar', 'FOOBAR'),
            array('Foobar', 'FOOBAR'),
            array('fooBar', 'FOOBAR'),
            array('FooBar', 'FOOBAR'),
            array('foo bar', 'FOO BAR'),
            array('foo Bar', 'FOO BAR'),
        );
    }
    
    public function getFullnames()
    {
        return array(
            array('foo', 'bar', 'foo BAR'),
            array('Foo', '', 'Foo'),
            array('Foo', null, 'Foo'),
            array('', 'bar', null),
            array(null, 'bar', null),
        );
    }
    
    public function getStrings()
    {
        return array(
            array('foo', 'bar', 'foo BAR'),
            array('Foo', '', 'Foo'),
            array('Foo', null, 'Foo'),
            array('', 'bar', ''),
            array(null, 'bar', ''),
        );
    }
    
    public function testNewObject()
    {
        $objectCreator = $this->getObjectCreator();
        $this->assertNull($objectCreator->getFullname());
        $this->assertEquals('', $objectCreator);
    }
    
    /**
     * @dataProvider getLastnames
     */
    public function testLastname($lastname, $result)
    {
        $objectCreator = $this->getObjectCreator();
        
        $objectCreator->setLastname($lastname);
        $this->assertEquals($result, $objectCreator->getLastname());
    }
    
    /**
     * @dataProvider getFullnames
     */
    public function testFullname($firstname, $lastname, $result)
    {
        $objectCreator = $this->getObjectCreator();
        
        $objectCreator->setFirstname($firstname);
        $objectCreator->setLastname($lastname);
        $this->assertEquals($result, $objectCreator->getFullname());
    }
    
    /**
     * @dataProvider getStrings
     */
    public function testToString($firstname, $lastname, $result)
    {
        $objectCreator = $this->getObjectCreator();
        
        $objectCreator->setFirstname($firstname);
        $objectCreator->setLastname($lastname);
        $this->assertEquals($result, $objectCreator);
    }
}