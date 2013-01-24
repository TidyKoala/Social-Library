<?php

namespace SocialLibrary\ReadBundle\MangaBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SocialLibrary\ReadBundle\MangaBundle\Entity\Serie;

/**
 * For test purposes. Allows to give basic manipulation on Serie
 *
 */
class TestSerie extends WebTestCase
{
    /**
     * Adds an Serie and return the saved object.
     * 
     * @param string $name
     * @return SocialLibrary\ReadBundle\MangaBundle\Entity\Serie
     */
    public function add($name)
    {
        if($name === '' || $name === null) {
            $entity = new Serie();
        } else {
            $client = static::createClient();
            $em = $client->getContainer()->get('doctrine.orm.entity_manager');
            $entity = $em->getRepository('SocialLibraryReadBundleMangaBundle:Serie')
                ->findOneBy(array(
                    'name' => $name,
                ));
    
            if (!$entity) {
                $entity = new Serie();
                $entity->setName($name);
                $em->persist($entity);
                $em->flush();
            }
        }
        
        return $entity;
    }
}