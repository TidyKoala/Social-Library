<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('volume')
            ->add('serie')
            ->add('creators')
            ->add('illustrators')
            ->add('language')
            ->add('isbn10')
            ->add('isbn13')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga'
        ));
    }

    public function getName()
    {
        return 'sociallibrary_readablemedia_mangabundle_mangatype';
    }
}
