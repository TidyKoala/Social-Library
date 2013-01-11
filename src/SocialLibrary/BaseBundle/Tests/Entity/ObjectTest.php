<?php

namespace SocialLibrary\BaseBundle\Tests\Entity;

use SocialLibrary\BaseBundle\Entity\ObjectCreator;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SocialLibrary\BaseBundle\Tests\Entity\ObjectTest
 * 
 */

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all functions related to the user: setOwners(), getOwners(), addOwner(), removeOwner(), isOwner()
     */
    public function testOwnership()
    {
        $object = $this->getObject();
        $user1 = new User();
        $user2 = new User();
        $user3 = new User();
        $user4 = new User();
        $user5 = new User();
        $arrayCollection = new ArrayCollection();
        
        /* Tests adding owners */
        $object->addOwner($user1);
        $this->assertEquals(1, $object->getOwners()->count());
        $object->addOwner($user2);
        $this->assertEquals(2, $object->getOwners()->count());
        $object->addOwner($user3);
        $object->addOwner($user4);
        $this->assertEquals(4, $object->getOwners()->count());
            /* - Test adding a known user */
        $object->addOwner($user1);
        $this->assertEquals(4, $object->getOwners()->count());
        
        /* Tests ownership */
        $this->assertTrue($object->isOwner($user1));
        $this->assertTrue($object->isOwner($user4));
        $this->assertFalse($object->isOwner($user5));
        
        /* Tests removing owners */
        $object->removeOwner($user1);
        $this->assertEquals(3, $object->getOwners()->count());
        $object->removeOwner($user2);
        $object->removeOwner($user3);
        $this->assertEquals(1, $object->getOwners()->count());
            /* - Tests removing unknown users */
        $object->removeOwner($user1);
        $this->assertEquals(1, $object->getOwners()->count());
        $object->removeOwner($user5);
        $this->assertEquals(1, $object->getOwners()->count());
        
        /* Tests ownership */
        $this->assertTrue($object->isOwner($user4));
        $this->assertFalse($object->isOwner($user1));
        $this->assertFalse($object->isOwner($user5));
        
        /* Tests setting users */
        $arrayCollection->add($user1);
        $arrayCollection->add($user2);
        $arrayCollection->add($user3);
        $arrayCollection->add($user5);
        $object->setOwners($arrayCollection);
        $this->assertEquals(4, $object->getOwners()->count());
        $this->assertTrue($object->isOwner($user1));
        $this->assertTrue($object->isOwner($user5));
        $this->assertFalse($object->isOwner($user4));
    }
    
    /**
     * Tests all functions related to the creator: setCreator(), getCreator(), addCreator(), removeCreator()
     */
    public function testCreators()
    {
        $object = $this->getObject();
        $objectCreator1 = new ObjectCreator();
        $objectCreator2 = new ObjectCreator();
        $objectCreator3 = new ObjectCreator();
        $objectCreator4 = new ObjectCreator();
        $objectCreator5 = new ObjectCreator();
        $arrayCollection = new ArrayCollection();
        
        /* Tests adding creators */
        $object->addCreator($objectCreator1);
        $this->assertEquals(1, $object->getCreators()->count());
        $object->addCreator($objectCreator2);
        $this->assertEquals(2, $object->getCreators()->count());
        $object->addCreator($objectCreator3);
        $object->addCreator($objectCreator4);
        $this->assertEquals(4, $object->getCreators()->count());
            /* Tests adding a known creator */
        $object->addCreator($objectCreator1);
        $this->assertEquals(4, $object->getCreators()->count());
        
        /* Tests removing creators */
        $object->removeCreator($objectCreator1);
        $this->assertEquals(3, $object->getCreators()->count());
        $object->removeCreator($objectCreator2);
        $object->removeCreator($objectCreator3);
        $this->assertEquals(1, $object->getCreators()->count());
            /* Tests removing unknown creators */
        $object->removeCreator($objectCreator3);
        $this->assertEquals(1, $object->getCreators()->count());
        
        /* Tests setting creators */
        $arrayCollection->add($objectCreator1);
        $arrayCollection->add($objectCreator2);
        $arrayCollection->add($objectCreator3);
        $arrayCollection->add($objectCreator4);
        $object->setCreators($arrayCollection);
        $this->assertEquals(4, $object->getCreators()->count());
    }
    
    /**
     * Creates a mock of SocialLibrary\BaseBundle\Entity\Object
     * 
     * @return SocialLibrary\BaseBundle\Entity\Object
     */
    protected function getObject()
    {
        return $this->getMockForAbstractClass('SocialLibrary\BaseBundle\Entity\Object');
    }
}