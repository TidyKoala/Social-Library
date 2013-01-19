<?php

namespace SocialLibrary\BaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ObjectCreatorControllerTest extends WebTestCase
{
    protected $client;
    protected $crawler;
    
    public function setUp()
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'testSuperAdmin',
            'PHP_AUTH_PW'   => '<testSuperAdmin>',
        ));
        $this->crawler = $this->client->getCrawler();
    }
    
    public function tearDown()
    {
        $this->client = null;
        $this->crawler = null;
    }
    
    function testAddCreatorWithoutErrors()
    {
        $this->crawler = $this->client->request('GET', '/object-creator/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_basebundle_objectcreatortype[firstname]' => 'Keith',
            'sociallibrary_basebundle_objectcreatortype[lastname]' => 'Harring',
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $response['code']);
        $this->assertEquals(0, count($response['error']));
        $this->assertEquals('Keith HARRING', $response['name']);
        
        
        $this->crawler = $this->client->request('GET', '/object-creator/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_basebundle_objectcreatortype[firstname]' => 'Eminem',
            'sociallibrary_basebundle_objectcreatortype[lastname]' => '',
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $response['code']);
        $this->assertEquals(0, count($response['error']));
        $this->assertEquals('Eminem ', $response['name']);
    }
    
    function testAddCreatorWithErrors()
    {
        $this->crawler = $this->client->request('GET', '/object-creator/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_basebundle_objectcreatortype[firstname]' => '',
            'sociallibrary_basebundle_objectcreatortype[lastname]' => '',
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $response['code']);
        $this->assertEquals(' ', $response['name']);
        $this->assertEquals(1, count($response['error']));
        $this->assertEquals('The firstname field cannot be left empty', $response['error'][0]);
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_basebundle_objectcreatortype[firstname]' => '',
            'sociallibrary_basebundle_objectcreatortype[lastname]' => 'Harring',
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $response['code']);
        $this->assertEquals(' HARRING', $response['name']);
        $this->assertEquals(1, count($response['error']));
        $this->assertEquals('The firstname field cannot be left empty', $response['error'][0]);
    }
}