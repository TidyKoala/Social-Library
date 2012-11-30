<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder
        	->add('firstname', null, array(
        			'label' => 'form.label_firstname',
        			'translation_domain' => 'SonataUserBundle',
        			'required' => true))
        	->add('lastname', null, array(
        			'label' => 'form.label_lastname',
        			'translation_domain' => 'SonataUserBundle',
        			'required' => true))
        	->add('dateOfBirth', 'birthday', array(
        			'label' => 'form.label_date_of_birth',
        			'translation_domain' => 'SonataUserBundle'
        			))
            ->add('locale', 'locale', array(
        			'label' => 'form.label_locale',
        			'translation_domain' => 'SonataUserBundle'
        			))
            ->add('timezone', 'timezone', array(
        			'label' => 'form.label_timezone',
        			'translation_domain' => 'SonataUserBundle'
        			))
            ->add('website', null, array(
        			'label' => 'form.label_website',
        			'translation_domain' => 'SonataUserBundle'
        			))
        ;
    }

    public function getName()
    {
        return 'application_sonata_user_registration';
    }
}