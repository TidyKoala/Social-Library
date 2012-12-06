<?php

namespace SocialLibrary\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ObjectCreatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                    'required' => true,
                    'label' => 'object_creator_label_firstname',
                ))
            ->add('lastname', 'text', array(
                    'required' => false,
                    'label' => 'object_creator_label_lastname',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialLibrary\BaseBundle\Entity\ObjectCreator'
        ));
    }

    public function getName()
    {
        return 'sociallibrary_basebundle_objectcreatortype';
    }
}
