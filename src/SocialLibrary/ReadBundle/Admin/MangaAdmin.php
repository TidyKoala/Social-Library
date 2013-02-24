<?php

namespace SocialLibrary\ReadBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class MangaAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->add('name', null, array('required' => true))
		->add('creators', null, array('required' => true))
		->add('illustrators', null, array('required' => false))
		->add('volume', null, array('required' => true))
		->add('serie', null, array('required' => true))
		->add('isbn10', null, array('required' => false))
		->add('isbn13', null, array('required' => false))
		->add('language', 'language', array('required' => false))
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
		->add('name')
		->add('serie')
		->add('creators')
		->add('illustrators')
		->add('isbn10')
		->add('isbn13')
		;
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name')
		->add('volume')
		->add('serie')
		->add('creators')
		->add('illustrators')
		;
	}

	public function validate(ErrorElement $errorElement, $object)
	{
	}
}
?>