<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Tests\Controller;

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
            array('Naruto', 'Naruto'),
            array('Bakuman', 'Bakuman'),
            array('Bleach', 'Bleach'),
            array('Prince of Tennis', 'Prince of Tennis'),
        );
    }
    
    function getInvalidValues()
    {
        return array(
            array(''),
            array(null),
        );
    }
    
    /**
     * @dataProvider getValidValues
     */
    function testSerieWithoutErrors($name, $result)
    {        
        $this->crawler = $this->client->request('GET', '/manga-serie/en/ajax-new', array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $this->crawler->selectButton('Add')->form(array(
            'sociallibrary_readablemedia_mangabundle_serieajaxtype[name]' => $name,
        ));
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(200, $response['code']);
        $this->assertEquals(0, count($response['error']));
        $this->assertEquals($result, $response['name']);
    }
}