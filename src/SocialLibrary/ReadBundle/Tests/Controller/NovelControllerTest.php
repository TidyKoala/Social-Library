<?php

namespace SocialLibrary\ReadBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SocialLibrary\BaseBundle\Tests\TestObjectCreator;
use SocialLibrary\ReadBundle\Tests\TestSerie;

class NovelControllerTest extends WebTestCase
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
    
    function addNewSerie($name)
    {
        $serie = new TestSerie();
        $serie = $serie->add($name);
        
        return $serie;
    }
    
    function addNewCreator($firstname, $lastname)
    {
        $object = new TestObjectCreator();
        $object = $object->add($firstname, $lastname);
        
        return $object;
    }
    
    function getValidValues()
    {
        return array_merge($this->getOtherOwnerValidValues(), $this->getOwnerValidValues());
    }
    
    function getOwnerValidValues()
    {
        return array(
            array('', '', 'Without Remorse', array('Tom', 'CLANCY'), '', '', ''),
            array('Jack Ryan', '1', 'The Hunt for Red October', array('Tom', 'CLANCY'), '', '', ''),
            array('', '', 'Rainbow Six', array('Tom', 'CLANCY'), 'en', '', ''),
            array('', '', 'Murder on the Orient Express', array('Agatha', 'CHRISTIE'), '', '0062073508', ''),
            array('Miss Marple Mysteries', '', 'The Murder at the Vicarage', array('Agatha', 'CHRISTIE'), '', '', '9780062073600'),
        );
    }
    
    function getOtherOwnerValidValues()
    {
        return array(
            array('', '', 'The Hobbit', array('J. R. R.', 'TOLKIEN'), '', '0345534832', ''),
            array('', '', 'Life of Pi', array('Yann', 'MARTEL'), 'en', '', ''),
            array('Jack Ryan', '', 'Locked On', array('Tom', 'CLANCY'), 'en', '0425248607', ''),
        );
    }
    
    function getCompletValidValues()
    {
        return array_merge($this->getCompletOtherOwnerValidValues(), $this->getCompletOwnerValidValues());
    }
    
    function getCompletOwnerValidValues()
    {
        return array(
            array('', '', 'Without Remorse', array('Tom', 'CLANCY'), 'en', '', ''),
            array('Jack Ryan', '1', 'The Hunt for Red October', array('Tom', 'CLANCY'), 'en', '', ''),
            array('', '', 'Rainbow Six', array('Tom', 'CLANCY'), 'en', '', ''),
            array('', '', 'Murder on the Orient Express', array('Agatha', 'CHRISTIE'), 'en', '0062073508', ''),
            array('Miss Marple Mysteries', '', 'The Murder at the Vicarage', array('Agatha', 'CHRISTIE'), 'en', '', '9780062073600'),
        );
    }
    
    function getCompletOtherOwnerValidValues()
    {
        return array(
            array('', '', 'The Hobbit', array('J. R. R.', 'TOLKIEN'), 'en', '061815082X', '9780618150823'),
            array('', '', 'Life of Pi', array('Yann', 'MARTEL'), 'en', '0547848412', '9780547848419'),
            array('Jack Ryan', '', 'Locked On', array('Tom', 'CLANCY'), 'en', '0425248607', '9780425248607'),
        );
    }
    
    function getInvalidValues()
    {
        return array(
            array('', '1', '', array('E. L.', 'JAMES'), '', '0345803485', '', 'The novel must have a name.'),
            array('', 'a', '', array('E. L.', 'JAMES'), '', '0345803485', '', 'This value is not valid.'),
            array('', '0', '', array('E. L.', 'JAMES'), '', '0345803485', '', 'novel_volume_min_length'),
            array('', '', 'Inferno', array('Dan', 'BROWN'), 'en', '1234567890', '', 'isbn10_incorrect'),
            array('', '', 'The Great Gatsby', array('F. Scott', 'FITZGERALD'), '', '', '1234567890123', 'isbn13_incorrect'),
        );
    }
    
    public function testEmptyIndex()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("novel_section_title")')->count());
        $this->assertEquals(5, $this->crawler->filter('table th')->count());
        $this->assertEquals(1, $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/novel/en/index/listThumbs');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("novel_section_title")')->count());
        $this->assertEquals(2, $this->crawler->filter('table th')->count());
        $this->assertEquals(1, $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/novel/en/index/thumbnails');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("novel_section_title")')->count());
        $this->assertEquals(0, $this->crawler->filter('ul.thumbnails.records_list li')->count());
    }
    
    /**
     * @dataProvider getOwnerValidValues
     */
    public function testAddWithoutErrors($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        
        $this->crawler = $this->client->request('GET', '/novel/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('novel_create')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dataProvider getInvalidValues
     */
    public function testAddWithErrors($serie, $volume, $name, $author, $language, $isbn10, $isbn13, $error)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        
        $this->crawler = $this->client->request('GET', '/novel/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('novel_create')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $this->client->submit($form);
        $this->assertFalse($this->client->getResponse()->isRedirect());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->crawler = $this->client->getCrawler();
        $this->assertEquals(1, $this->crawler->filter('li:contains("' . $error . '")')->count());
    }
    
    /**
     * @dataProvider getOtherOwnerValidValues
     */
    public function testAddNotOwner($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'testUser',
            'PHP_AUTH_PW'   => '<testUser>',
        ));
        $this->crawler = $this->client->getCrawler();
        
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        
        $this->crawler = $this->client->request('GET', '/novel/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('novel_create')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     */
    public function testFullIndex()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("novel_section_title")')->count());
        $this->assertEquals(5, $this->crawler->filter('table th')->count());
        $this->assertEquals((1 + count($this->getValidValues())), $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/novel/en/index/listThumbs');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("novel_section_title")')->count());
        $this->assertEquals(2, $this->crawler->filter('table th')->count());
        $this->assertEquals((1 + count($this->getValidValues())), $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/novel/en/index/thumbnails');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("novel_section_title")')->count());
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('ul.thumbnails.records_list li')->count());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     */
    public function testOwnershipLink1()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(count($this->getOtherOwnerValidValues()), $this->crawler->filter('a:contains("novel_own")')->count());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     */
    public function testNotOwnershipLink1()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(count($this->getOwnerValidValues()), $this->crawler->filter('a:contains("novel_delete")')->count());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     * @dataProvider getValidValues
     */
    public function testShow($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $link = $this->crawler->filter('tr:contains("'.$author[0] . ' ' . $author[1].'")')->selectLink($name)->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($volume . ' - ' . $name . ' - ' . $serie, $this->crawler->filter('h1')->text());
        $this->assertEquals($volume, $this->crawler->filter('td')->eq(0)->text());
        $this->assertEquals($name, $this->crawler->filter('td')->eq(1)->text());
        $this->assertEquals($serie, $this->crawler->filter('td')->eq(2)->text());
        $this->assertEquals($author[0] . ' ' . $author[1], $this->crawler->filter('td')->eq(3)->text());
        $this->assertEquals($language, $this->crawler->filter('td')->eq(4)->text());
        $this->assertEquals($isbn10, $this->crawler->filter('td')->eq(5)->text());
        $this->assertEquals($isbn13, $this->crawler->filter('td')->eq(6)->text());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dataProvider getCompletOwnerValidValues
     */
    public function testEditWithoutErrors($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $row = $this->crawler->filter('tr:contains("'.$author[0] . ' ' . $author[1].'")')->filter('tr:contains("'.$name.'")');
        $this->assertEquals(1, $row->filter('a:contains("novel_edit")')->count());
        $link = $row->selectLink('novel_edit')->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('novel_edit')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testAddNotOwner
     * @dataProvider getOtherOwnerValidValues
     */
    public function testEditNotOwner($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(0, $this->crawler->filter('tr:contains("'.$author[0] . ' ' . $author[1].'")')->filter('tr:contains("'.$name.'")')->filter('a:contains("Edit")')->count());
    }
    
    /**
     * @dependsOn testAddNotOwner
     * @dataProvider getOtherOwnerValidValues
     */
    public function testAddOwnership($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $row = $this->crawler->filter('tr:contains("'.$author[0] . ' ' . $author[1].'")')->filter('tr:contains("'.$name.'")');
        $link = $row->selectLink('novel_own')->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testAddOwnership
     */
    public function testOwnershipLink2()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('a:contains("novel_delete")')->count());
    }
    
    /**
     * @dependsOn testAddOwnership
     */
    public function testNotOwnershipLink2()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(0, $this->crawler->filter('a:contains("novel_own")')->count());
    }
    
    /**
     * @dependsOn testEditWithoutErrors
     * @dataProvider getOwnerValidValues
     */
    public function testRemoveOwnership($serie, $volume, $name, $author, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $row = $this->crawler->filter('tr:contains("'.$author[0] . ' ' . $author[1].'")')->filter('tr:contains("'.$name.'")');
        $link = $row->selectLink('novel_delete')->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testRemoveOwnership
     */
    public function testOwnershipLink3()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(count($this->getOtherOwnerValidValues()), $this->crawler->filter('a:contains("novel_delete")')->count());
    }
    
    /**
     * @dependsOn testRemoveOwnership
     */
    public function testNotOwnershipLink3()
    {
        $this->crawler = $this->client->request('GET', '/novel/en/index');
        $this->assertEquals(count($this->getOwnerValidValues()), $this->crawler->filter('a:contains("novel_own")')->count());
    }
}