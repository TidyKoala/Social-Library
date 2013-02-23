<?php

namespace SocialLibrary\ReadBundle\CommonBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SerieControllerTest extends WebTestCase
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
    
    function getValidValues()
    {
        return array(
            array('One Piece', 'One Piece'),
            array('Pokemon', 'Pokemon'),
            array('Black Cat', 'Black Cat'),
            array('Prince of Tennis', 'Prince of Tennis'),
        );
    }
    
    function getInvalidValues()
    {
        return array(
            array('', 'The serie must have a name'),
            array(null, 'The serie must have a name'),
            array('pokemon', 'serie_already_exists'),
            array('black Cat', 'serie_already_exists'),
            array('Prince OF tENNIS', 'serie_already_exists'),
        );
    }
    
    /**
     * @dataProvider getValidValues
     */
    function testAddSerieWithoutErrors($name, $result)
    {        
        $this->crawler = $this->client->request('GET', '/read-serie/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_readbundle_commonbundle_serieajaxtype[name]' => $name,
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $response['code']);
        $this->assertEquals(0, count($response['error']));
        $this->assertEquals($result, $response['name']);
    }
    
    /**
     * @dataProvider getInvalidValues
     */
    function testAddSerieWithErrors($name, $error)
    {
        $this->crawler = $this->client->request('GET', '/read-serie/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_readbundle_commonbundle_serieajaxtype[name]' => $name,
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $response['code']);
        $this->assertEquals(1, count($response['error']));
        $this->assertEquals($error, $response['error'][0]);
    }
}