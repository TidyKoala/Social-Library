<?php

namespace SocialLibrary\BaseBundle\Tests;

use Doctrine\ORM\EntityManager;
use SocialLibrary\BaseBundle\Entity\ObjectCreator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * For test purposes. Allows to give basic manipulation on ObjectCreators
 *
 */
class TestObjectCreator extends WebTestCase
{
    /**
     * Adds an ObjectCreator and return the saved object.
     * 
     * @param string $firstname
     * @param string $lastname
     * @return SocialLibrary\BaseBundle\Entity\ObjectCreator
     */
    public function add($firstname, $lastname)
    {
        if($firstname === '' || $firstname === null) {
            $entity = new ObjectCreator();
        } else {
            $client = static::createClient();
            $em = $client->getContainer()->get('doctrine.orm.entity_manager');
            $entity = $em->getRepository('SocialLibraryBaseBundle:ObjectCreator')
                ->findOneBy(array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                ));
    
            if (!$entity) {
                $entity = new ObjectCreator();
                $entity->setFirstname($firstname);
                $entity->setLastname($lastname);
                $em->persist($entity);
                $em->flush();
            }
        }
        
        return $entity;
    }
}