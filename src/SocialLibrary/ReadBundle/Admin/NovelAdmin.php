<?php

namespace SocialLibrary\ReadBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class NovelAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->add('name', null, array('required' => true))
		->add('creators', null, array('required' => true))
		->add('volume', null, array('required' => false))
		->add('serie', null, array('required' => false))
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
		->add('isbn10')
		->add('isbn13')
		;
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name')
		->add('serie')
		->add('creators')
		;
	}

	public function validate(ErrorElement $errorElement, $object)
	{
	}
}
?>