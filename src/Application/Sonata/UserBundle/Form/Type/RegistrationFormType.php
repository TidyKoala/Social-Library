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
        	->add('firstname')
        	->add('lastname')
        	->add('dateOfBirth', 'birthday')
        ;
    }

    public function getName()
    {
        return 'application_sonata_user_registration';
    }
}