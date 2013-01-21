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
    
    public function getValidValues() {
        return array(
            array('Keith', 'Harring', 'Keith HARRING'),
            array('Eminem', '', 'Eminem'),
            array('Moby', null, 'Moby'),
        );
    }
    
    public function getInvalidValues() {
        return array(
            array('', ''),
            array('', 'Eminem'),
        );
    }
    
    /**
     * @dataProvider getValidValues
     */
    function testAddCreatorWithoutErrors($firstname, $lastname, $fullname)
    {        
        $this->crawler = $this->client->request('GET', '/object-creator/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_basebundle_objectcreatortype[firstname]' => $firstname,
            'sociallibrary_basebundle_objectcreatortype[lastname]' => $lastname,
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $response['code']);
        $this->assertEquals(0, count($response['error']));
        $this->assertEquals($fullname, $response['name']);
    }
    
    /**
     * @dataProvider getInvalidValues
     */
    function testAddCreatorWithErrors($firstname, $lastname)
    {
        $this->crawler = $this->client->request('GET', '/object-creator/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
                'sociallibrary_basebundle_objectcreatortype[firstname]' => $firstname,
                'sociallibrary_basebundle_objectcreatortype[lastname]' => $lastname,
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $response['code']);
        $this->assertNull($response['name']);
        $this->assertEquals(1, count($response['error']));
        $this->assertEquals('The firstname field cannot be left empty.', $response['error'][0]);
    }
    
    /**
     * @depends testAddCreatorWithoutErrors
     * @dataProvider getValidValues
     */
    function testAddExistingCreator($firstname, $lastname, $fullname)
    {        
        $this->crawler = $this->client->request('GET', '/object-creator/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_basebundle_objectcreatortype[firstname]' => $firstname,
            'sociallibrary_basebundle_objectcreatortype[lastname]' => $lastname,
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $response['code']);
        $this->assertEquals(1, count($response['error']));
        $this->assertEquals('The creator is already registred in the database.', $response['error'][0]);
    }
}