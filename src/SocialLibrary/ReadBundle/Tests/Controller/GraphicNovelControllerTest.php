<?php

namespace SocialLibrary\ReadBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SocialLibrary\BaseBundle\Tests\TestObjectCreator;
use SocialLibrary\ReadBundle\Tests\TestSerie;

class GraphicNovelBundleControllerTest extends WebTestCase
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
    
    /**
     * @param string $name
     * @return SocialLibrary\ReadBundle\Entity\Serie
     */
    function addNewSerie($name)
    {
        $serie = new TestSerie();
        $serie = $serie->add($name);
        
        return $serie;
    }
    
    /**
     * @param string $firstname
     * @param string $lastname
     * @return SocialLibrary\BaseBundle\Entity\ObjectCreator
     */
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
            array('Tintin', '', 'Flight 714', array(array('Hergé', '')), array(array('Hergé', '')), '', '', ''),
            array('Tintin', '', 'Tintin and the Picaros', array(array('Hergé', '')), array(array('Hergé', '')), 'en', '', ''),
            array('Largo Winch', '1', 'The Heir', array(array('Van', 'JEAN HAMME')), array(array('Phillipe', 'FRANQ')), '', '', '9781905460489'),
            array('Astérix', '', 'Asterix the Gaul', array(array('Rene', 'GOSCINNY')), array(array('Albert', 'UDERZO')), '', '', ''),
            array('The Walking Dead', '1', 'Compendium One', array(array('Robert', 'KIRKMAN')), array(array('Charlie', 'ADLARD'), array('Cliff', 'RATHBURN'), array('Tony', 'MOORE')), '', '1607060760', ''),
            array('Bone', '8', 'Treasure Hunters', array(array('Jeff', 'SMITH')), array(array('Jeff', 'SMITH')), 'en', '1888963123', '9781888963120'),
        );
    }
    
    function getOtherOwnerValidValues()
    {
        return array(
            array('Lanfeust de Troy', '3', 'Castel Or-Azur', array(array('Christophe', 'ARLESTON')), array(array('Didier', 'TARQUIN')), '', '', '9782302015920'),
            array('Spirou & Fantasio', '1', 'Adventure Down Under', array(array('Tome', '')), array(array('Janry', '')), 'en', '', ''),
            array('Blake and Mortimer', '1', 'The Yellow \'M\'', array(array('Edgar', 'P. JACOBS')), array(array('Edgar', 'P. JACOBS')), 'en', '190546021X', ''),
        );
    }
    
    function getCompletValidValues()
    {
        return array_merge($this->getCompletOtherOwnerValidValues(), $this->getCompletOwnerValidValues());
    }
    
    function getCompletOwnerValidValues()
    {
        return array(
            array('Tintin', '', 'Flight 714', array(array('Hergé', '')), array(array('Hergé', '')), 'en', '0316358371', '9780316358378'),
            array('Tintin', '', 'Tintin and the Picaros', array(array('Hergé', '')), array(array('Hergé', '')), 'en', '0316358495', '9780316358491'),
            array('Largo Winch', '1', 'The Heir', array(array('Van', 'JEAN HAMME')), array(array('Phillipe', 'FRANQ')), 'en', '1905460481', '9781905460489'),
            array('Astérix', '', 'Asterix the Gaul', array(array('Rene', 'GOSCINNY')), array(array('Albert', 'UDERZO')), 'en', '0752866052', '9780752866055'),
            array('The Walking Dead', '1', 'Compendium One', array(array('Robert', 'KIRKMAN')), array(array('Charlie', 'ADLARD'), array('Cliff', 'RATHBURN'), array('Tony', 'MOORE')), 'en', '1607060760', '9781607060765'),
            array('Bone', '8', 'Treasure Hunters', array(array('Jeff', 'SMITH')), array(array('Jeff', 'SMITH')), 'en', '1888963123', '9781888963120'),
        );
    }
    
    function getCompletOtherOwnerValidValues()
    {
        return array(
            array('Lanfeust de Troy', '3', 'Castel Or-Azur', array(array('Christophe', 'ARLESTON')), array(array('Didier', 'TARQUIN')), 'fr', '2302015924', '9782302015920'),
            array('Spirou & Fantasio', '1', 'Adventure Down Under', array(array('Tome', '')), array(array('Janry', '')), 'en', '1849180113', '9781849180115'),
            array('Blake and Mortimer', '1', 'The Yellow \'M\'', array(array('Edgar', 'P. JACOBS')), array(array('Edgar', 'P. JACOBS')), 'en', '190546021X', '9781905460212'),
        );
    }
    
    function getInvalidValues()
    {
        return array(
            array('Bone', '1', '', array(array('Rene', 'GOSCINNY')), array(array('Tabary', '')), 'en', '1905460465', '9781905460465', 'The novel must have a name.'),
            array('Bone', '35', 'The Singing Wire', array(array('Rene', 'GOSCINNY')), array(array('Morris', '')), 'en', '1234567890', '', 'isbn10_incorrect'),
            array('Bone', '5', 'Rumberley', array('Raoul', 'CAUVIN'), array('Willy', 'LAMBILl'), 'en', '184918108X', '1234567890123', 'isbn13_incorrect'),
        );
    }
    
    public function testEmptyIndex()
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("graphic_novel_section_title")')->count());
        $this->assertEquals(5, $this->crawler->filter('table th')->count());
        $this->assertEquals(1, $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index/listThumbs');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("graphic_novel_section_title")')->count());
        $this->assertEquals(2, $this->crawler->filter('table th')->count());
        $this->assertEquals(1, $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index/thumbnails');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("graphic_novel_section_title")')->count());
        $this->assertEquals(0, $this->crawler->filter('ul.thumbnails.records_list li')->count());
    }
    
    /**
     * @dataProvider getOwnerValidValues
     */
    public function testAddWithoutErrors($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        $respSerie = $this->addNewSerie($serie);
        foreach ($authors as $author) {
            $respAuthor[] = $this->addNewCreator($author[0], $author[1])->getId();
        }
        foreach ($illustrators as $illustrator) {
            $respIllustrator[] = $this->addNewCreator($illustrator[0], $illustrator[1])->getId();
        }
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('graphic_novel_create')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $form['book[creators]']->select($respAuthor);
        $form['book[illustrators]']->select($respIllustrator);
        $this->client->submit($form);
        
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dataProvider getInvalidValues
     */
    public function testAddWithErrors($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13, $error)
    {
        $respSerie = $this->addNewSerie($serie);
        foreach ($authors as $author) {
            $respAuthor[] = $this->addNewCreator($author[0], $author[1])->getId();
        }
        foreach ($illustrators as $illustrator) {
            $respIllustrator[] = $this->addNewCreator($illustrator[0], $illustrator[1])->getId();
        }
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('graphic_novel_create')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $form['book[creators]']->select($respAuthor);
        $form['book[illustrators]']->select($respIllustrator);
        $this->client->submit($form);
        
        $this->assertFalse($this->client->getResponse()->isRedirect());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->crawler = $this->client->getCrawler();
        $this->assertEquals(1, $this->crawler->filter('li:contains("' . $error . '")')->count());
    }
    
    /**
     * @dataProvider getOtherOwnerValidValues
     */
    public function testAddNotOwner($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'testUser',
            'PHP_AUTH_PW'   => '<testUser>',
        ));
        $this->crawler = $this->client->getCrawler();
        
        $respSerie = $this->addNewSerie($serie);
        foreach ($authors as $author) {
            $respAuthor[] = $this->addNewCreator($author[0], $author[1])->getId();
        }
        foreach ($illustrators as $illustrator) {
            $respIllustrator[] = $this->addNewCreator($illustrator[0], $illustrator[1])->getId();
        }
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('graphic_novel_create')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $form['book[creators]']->select($respAuthor);
        $form['book[illustrators]']->select($respIllustrator);
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
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("graphic_novel_section_title")')->count());
        $this->assertEquals(5, $this->crawler->filter('table th')->count());
        $this->assertEquals(count($this->getValidValues()) + 1, $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index/listThumbs');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("graphic_novel_section_title")')->count());
        $this->assertEquals(2, $this->crawler->filter('table th')->count());
        $this->assertEquals(count($this->getValidValues()) + 1, $this->crawler->filter('table tr')->count());
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index/thumbnails');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("graphic_novel_section_title")')->count());
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('ul.thumbnails.records_list li')->count());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     */
    public function testOwnershipLink1()
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(count($this->getOwnerValidValues()), $this->crawler->filter('a:contains("graphic_novel_delete")')->count());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     */
    public function testNotOwnershipLink1()
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(count($this->getOtherOwnerValidValues()), $this->crawler->filter('a:contains("graphic_novel_own")')->count());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dependsOn testAddNotOwner
     * @dataProvider getValidValues
     */
    public function testShow($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        foreach ($authors as $author) {
            $respAuthor[] = ($author[1]) ? $author[0] . ' ' . $author[1] : $author[0];
        }
        foreach ($illustrators as $illustrator) {
            $respIllustrator[] = ($illustrator[1]) ? $illustrator[0] . ' ' . $illustrator[1] : $illustrator[0];
        }
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $link = $this->crawler->selectLink($name)->link();
        $this->crawler = $this->client->click($link);
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($volume . ' - ' . $name . ' - ' . $serie, $this->crawler->filter('h1')->text());
        $this->assertEquals($volume, $this->crawler->filter('td')->eq(0)->text());
        $this->assertEquals($name, $this->crawler->filter('td')->eq(1)->text());
        $this->assertEquals($serie, $this->crawler->filter('td')->eq(2)->text());
        $this->assertEquals(join(', ', $respAuthor), $this->crawler->filter('td')->eq(3)->text());
        $this->assertEquals(join(', ', $respIllustrator), $this->crawler->filter('td')->eq(4)->text());
        $this->assertEquals($language, $this->crawler->filter('td')->eq(5)->text());
        $this->assertEquals($isbn10, $this->crawler->filter('td')->eq(6)->text());
        $this->assertEquals($isbn13, $this->crawler->filter('td')->eq(7)->text());
    }
    
    /**
     * @dependsOn testAddWithoutErrors
     * @dataProvider getCompletOwnerValidValues
     */
    public function testEditWithoutErrors($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        $respSerie = $this->addNewSerie($serie);
        foreach ($authors as $author) {
            $respAuthor[] = $this->addNewCreator($author[0], $author[1])->getId();
        }
        foreach ($illustrators as $illustrator) {
            $respIllustrator[] = $this->addNewCreator($illustrator[0], $illustrator[1])->getId();
        }
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $row = $this->crawler->filter('tr:contains("'.$name.'")');
        $this->assertEquals(1, $row->filter('a:contains("graphic_novel_edit")')->count());
        $link = $row->selectLink('graphic_novel_edit')->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('Edit')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $form['book[creators]']->select($respAuthor);
        $form['book[illustrators]']->select($respIllustrator);
        $this->client->submit($form);
        
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testAddNotOwner
     * @dataProvider getOtherOwnerValidValues
     */
    public function testEditNotOwner($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(0, $this->crawler->filter('tr:contains("'.$name.'")')->filter('a:contains("graphic_novel_edit")')->count());
    }
    
    /**
     * @dataProvider getInvalidValues
     */
    public function testEditWithErrors($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13, $error)
    {
        $respSerie = $this->addNewSerie($serie);
        foreach ($authors as $author) {
            $respAuthor[] = $this->addNewCreator($author[0], $author[1])->getId();
        }
        foreach ($illustrators as $illustrator) {
            $respIllustrator[] = $this->addNewCreator($illustrator[0], $illustrator[1])->getId();
        }
        
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $link = $this->crawler->filter('tr:contains("'.$serie.'")')->selectLink('graphic_novel_edit')->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton('Edit')->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $form['book[creators]']->select($respAuthor);
        $form['book[illustrators]']->select($respIllustrator);
        $this->client->submit($form);
        
        $this->assertFalse($this->client->getResponse()->isRedirect());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->crawler = $this->client->getCrawler();
        $this->assertEquals(1, $this->crawler->filter('li:contains("' . $error . '")')->count());
    }
    
    /**
     * @dependsOn testAddNotOwner
     * @dataProvider getOtherOwnerValidValues
     */
    public function testAddOwnership($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $row = $this->crawler->filter('tr:contains("'.$name.'")');
        $link = $row->selectLink('graphic_novel_own')->link();
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
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('a:contains("graphic_novel_delete")')->count());
    }
    
    /**
     * @dependsOn testAddOwnership
     */
    public function testNotOwnershipLink2()
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(0, $this->crawler->filter('a:contains("graphic_novel_own")')->count());
    }
    
    /**
     * @dependsOn testEditWithoutErrors
     * @dataProvider getOwnerValidValues
     */
    public function testRemoveOwnership($serie, $volume, $name, $authors, $illustrators, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $row = $this->crawler->filter('tr:contains("'.$name.'")');
        $link = $row->selectLink('graphic_novel_delete')->link();
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
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(count($this->getCompletOtherOwnerValidValues()), $this->crawler->filter('a:contains("graphic_novel_delete")')->count());
    }
    
    /**
     * @dependsOn testRemoveOwnership
     */
    public function testNotOwnershipLink3()
    {
        $this->crawler = $this->client->request('GET', '/graphic-novel/en/index');
        $this->assertEquals(count($this->getCompletOwnerValidValues()), $this->crawler->filter('a:contains("graphic_novel_own")')->count());
    }
}