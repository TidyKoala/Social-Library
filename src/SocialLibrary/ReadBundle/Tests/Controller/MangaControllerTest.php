<?php

namespace SocialLibrary\ReadBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SocialLibrary\BaseBundle\Tests\TestObjectCreator;
use SocialLibrary\ReadBundle\Tests\TestSerie;

class MangaControllerTest extends WebTestCase
{
    protected $client;
    protected $crawler;
    protected $locale;
    protected $translator;
    
    public function setUp()
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'testSuperAdmin',
            'PHP_AUTH_PW'   => '<testSuperAdmin>',
        ));
        $this->crawler = $this->client->getCrawler();
        $this->locale = $this->client->getContainer()->get('sonata.intl.templating.helper.locale');
        $this->translator = $this->client->getContainer()->get('translator');
    }
    
    public function tearDown()
    {
        $this->client->getContainer()->get('doctrine')->getConnection()->close();
    	parent::tearDown();
        $this->client = null;
        $this->crawler = null;
        $this->locale = null;
        $this->translator = null;
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
            array('Naruto', '1', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), '', '', ''),
            array('Naruto', '2', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), 'en', '', ''),
            array('Naruto', '4', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), '', '', '9782871294412'),
            array('Bakuman', '1', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), '', '', ''),
            array('Bakuman', '3', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), '', '2505009635', ''),
            array('Bakuman', '4', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), '', '', '9782505009887'),
        );
    }
    
    function getOtherOwnerValidValues()
    {
        return array(
            array('Naruto', '3', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), '', '2871294275', ''),
            array('Bakuman', '2', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), 'de', '', ''),
            array('Bleach', '1', 'The Death and the Strawberry', array('Tite', 'KUBO'), array('Tite', 'KUBO'), 'fr', '2723442276', ''),
            array('Bleach', '2', 'Goodbye Parakeet, Goodnite my sista', array('Tite', 'KUBO'), array('Tite', 'KUBO'), 'fr', '2723442284', '9782723442282'),
        );
    }
    
    function getCompletValidValues()
    {
        return array_merge($this->getCompletOtherOwnerValidValues(), $this->getCompletOwnerValidValues());
    }
    
    function getCompletOwnerValidValues()
    {
        return array(
            array('Naruto', '1', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), 'fr', '2871294143', '9782871294146'),
            array('Naruto', '2', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), 'fr', '2871294178', '9782871294177'),
            array('Naruto', '4', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), 'fr', '2871294410', '9782871294412'),
            array('Bakuman', '1', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), 'fr', '2505008264', '9782505008262'),
            array('Bakuman', '3', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), 'fr', '2505009635', '9782505009634'),
            array('Bakuman', '4', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), 'fr', '2505009880', '9782505009887'),
        );
    }
    
    function getCompletOtherOwnerValidValues()
    {
        return array(
            array('Naruto', '3', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), 'fr', '2871294275', '9782871294276'),
            array('Bakuman', '2', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), 'fr', '2505008272', '9782505008279'),
            array('Bleach', '1', 'The Death and the Strawberry', array('Tite', 'KUBO'), array('Tite', 'KUBO'), 'fr', '2723442276', '9782723442275'),
            array('Bleach', '2', 'Goodbye Parakeet, Goodnite my sista', array('Tite', 'KUBO'), array('Tite', 'KUBO'), 'fr', '2723442284', '9782723442282'),
        );
    }
    
    function getInvalidValues()
    {
        return array(
            array('Naruto', '1', '', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), '', '', '', 'The novel must have a name.'),
            array('Naruto', '', 'Naruto', array('Masashi', 'KISHIMOTO'), array('Masashi', 'KISHIMOTO'), 'en', '', '', 'manga_volume_not_blank'),
            array('Bakuman', '2', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), 'de', '1234567890', '', 'isbn10_incorrect'),
            array('Bakuman', '3', 'Bakuman', array('Tsugumi', 'OHBA'), array('Takeshi', 'OBATA'), '', '2505009635', '1234567890123', 'isbn13_incorrect'),
        );
    }
    
    public function testEmptyIndex()
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("' . $this->translator->trans('manga_section_title') . '")')->count());
        $this->assertEquals(0, $this->crawler->filter('.list-view .object')->count());
        
        $this->crawler = $this->client->request('GET', '/manga/en/index/listThumbs');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("' . $this->translator->trans('manga_section_title') . '")')->count());
        $this->assertEquals(0, $this->crawler->filter('.list-thumb-view .object')->count());
        
        $this->crawler = $this->client->request('GET', '/manga/en/index/thumbnails');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("' . $this->translator->trans('manga_section_title') . '")')->count());
        $this->assertEquals(0, $this->crawler->filter('.thumbnail-view .object')->count());
    }
    
    /**
     * @dataProvider getOwnerValidValues
     */
    public function testAddMangaWithoutErrors($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        $respIllustrator = $this->addNewCreator($illustrator[0], $illustrator[1]);
        
        $this->crawler = $this->client->request('GET', '/manga/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton($this->translator->trans('label_book_create'))->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[illustrators]' => $respIllustrator->getId(),
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
    public function testAddMangaWithErrors($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13, $error)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        $respIllustrator = $this->addNewCreator($illustrator[0], $illustrator[1]);
        
        $this->crawler = $this->client->request('GET', '/manga/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton($this->translator->trans('label_book_create'))->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[illustrators]' => $respIllustrator->getId(),
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
    public function testAddMangaNotOwner($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'testUser',
            'PHP_AUTH_PW'   => '<testUser>',
        ));
        $this->crawler = $this->client->getCrawler();
        
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        $respIllustrator = $this->addNewCreator($illustrator[0], $illustrator[1]);
        
        $this->crawler = $this->client->request('GET', '/manga/en/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton($this->translator->trans('label_book_create'))->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[illustrators]' => $respIllustrator->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testAddMangaWithoutErrors
     * @dependsOn testAddMangaNotOwner
     */
    public function testFullIndex()
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("' . $this->translator->trans('manga_section_title') . '")')->count());
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('.list-view .object')->count());
        
        $this->crawler = $this->client->request('GET', '/manga/en/index/listThumbs');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("' . $this->translator->trans('manga_section_title') . '")')->count());
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('.list-thumb-view .object')->count());
        
        $this->crawler = $this->client->request('GET', '/manga/en/index/thumbnails');
        $this->assertEquals(1 , $this->crawler->filter('h1:contains("' . $this->translator->trans('manga_section_title') . '")')->count());
        $this->assertEquals(count($this->getValidValues()), $this->crawler->filter('.thumbnail-view .object')->count());
    }
    
    /**
     * @dependsOn testAddMangaWithoutErrors
     * @dependsOn testAddMangaNotOwner
     */
    public function testOwnershipLink1()
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(6, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_remove_owner') . '")')->count());
    }
    
    /**
     * @dependsOn testAddMangaWithoutErrors
     * @dependsOn testAddMangaNotOwner
     */
    public function testNotOwnershipLink1()
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(4, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_add_owner') . '")')->count());
    }
    
    /**
     * @dependsOn testAddMangaWithoutErrors
     * @dependsOn testAddMangaNotOwner
     * @dataProvider getValidValues
     */
    public function testShowManga($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $link = $this->crawler->filter('tr:contains("'.$volume.'")')->selectLink($name)->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($volume . ' - ' . $name . ' - ' . $serie, $this->crawler->filter('h1')->text());
        $this->assertEquals($volume, $this->crawler->filter('td')->eq(0)->text());
        $this->assertEquals($name, $this->crawler->filter('td')->eq(1)->text());
        $this->assertEquals($serie, $this->crawler->filter('td')->eq(2)->text());
        $this->assertEquals($author[0] . ' ' . $author[1], $this->crawler->filter('td')->eq(3)->text());
        $this->assertEquals($illustrator[0] . ' ' . $illustrator[1], $this->crawler->filter('td')->eq(4)->text());
        $this->assertEquals($this->locale->language($language, 'en'), $this->crawler->filter('td')->eq(5)->text());
        $this->assertEquals($isbn10, $this->crawler->filter('td')->eq(6)->text());
        $this->assertEquals($isbn13, $this->crawler->filter('td')->eq(7)->text());
    }
    
    /**
     * @dependsOn testAddMangaWithoutErrors
     * @dataProvider getCompletOwnerValidValues
     */
    public function testEditMangaWithoutErrors($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        $respIllustrator = $this->addNewCreator($illustrator[0], $illustrator[1]);
        
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $row = $this->crawler->filter('tr:contains("'.$volume.'")')->filter('tr:contains("'.$serie.'")');
        $this->crawler = $this->client->click($row->selectLink($name)->link());
        $this->assertEquals(1, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_edit') . '")')->count());
        $link = $this->crawler->selectLink($this->translator->trans('link_book_edit'))->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton($this->translator->trans('label_book_edit'))->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[illustrators]' => $respIllustrator->getId(),
            'book[language]' => $language,
            'book[isbn10]' => $isbn10,
            'book[isbn13]' => $isbn13,
        ));
        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * @dependsOn testAddMangaNotOwner
     * @dataProvider getOtherOwnerValidValues
     */
    public function testEditMangaNotOwner($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(0, $this->crawler->filter('tr:contains("'.$volume.'")')->filter('tr:contains("'.$serie.'")')->filter('a:contains("' . $this->translator->trans('link_book_edit') . '")')->count());
    }
    
    /**
     * @dataProvider getInvalidValues
     */
    public function testEditMangaWithErrors($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13, $error)
    {
        $respSerie = $this->addNewSerie($serie);
        $respAuthor = $this->addNewCreator($author[0], $author[1]);
        $respIllustrator = $this->addNewCreator($illustrator[0], $illustrator[1]);
        
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $link = $this->crawler->filter('tr:contains("'.$serie.'")')->eq(0)->selectLink($this->translator->trans('link_book_details'))->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->selectLink($this->translator->trans('link_book_edit'))->link();
        $this->crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $form = $this->crawler->selectButton($this->translator->trans('label_book_edit'))->form(array(
            'book[name]' => $name,
            'book[volume]' => $volume,
            'book[serie]' => $respSerie->getId(),
            'book[creators]' => $respAuthor->getId(),
            'book[illustrators]' => $respIllustrator->getId(),
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
     * @dependsOn testAddMangaNotOwner
     * @dataProvider getOtherOwnerValidValues
     */
    public function testAddOwnership($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $row = $this->crawler->filter('tr:contains("'.$volume.'")')->filter('tr:contains("'.$serie.'")');
        $link = $row->selectLink($this->translator->trans('link_book_add_owner'))->link();
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
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(10, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_remove_owner') . '")')->count());
    }
    
    /**
     * @dependsOn testAddOwnership
     */
    public function testNotOwnershipLink2()
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(0, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_add_owner') . '")')->count());
    }
    
    /**
     * @dependsOn testEditMangaWithoutErrors
     * @dataProvider getOwnerValidValues
     */
    public function testRemoveOwnership($serie, $volume, $name, $author, $illustrator, $language, $isbn10, $isbn13)
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $row = $this->crawler->filter('tr:contains("'.$volume.'")')->filter('tr:contains("'.$serie.'")');
        $link = $row->selectLink($this->translator->trans('link_book_remove_owner'))->link();
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
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(4, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_remove_owner') . '")')->count());
    }
    
    /**
     * @dependsOn testRemoveOwnership
     */
    public function testNotOwnershipLink3()
    {
        $this->crawler = $this->client->request('GET', '/manga/en/index');
        $this->assertEquals(6, $this->crawler->filter('a:contains("' . $this->translator->trans('link_book_add_owner') . '")')->count());
    }
}