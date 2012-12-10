<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Form\Type;

use SocialLibrary\BaseBundle\Form\Type\ObjectCreatorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'manga_label_name',
                ))
            ->add('volume', 'integer', array(
                    'required' => true,
                    'label' => 'manga_label_volume',
                ))
            ->add('serie', 'entity', array(
                    'required' => true,
                    'label' => 'manga_label_serie',
                    'class' => 'SocialLibrary\ReadableMedia\MangaBundle\Entity\Serie',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->orderBy('s.nameSlug', 'ASC');
                    },
                    'multiple' => false,
                ))
            ->add('creators', 'entity', array(
                    'required' => true,
                    'label' => 'manga_label_creators',
                    'class' => 'SocialLibrary\BaseBundle\Entity\ObjectCreator',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.nameSlug', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => false,
                ))
            ->add('illustrators', 'entity', array(
                    'required' => true,
                    'label' => 'manga_label_illustrators',
                    'class' => 'SocialLibrary\BaseBundle\Entity\ObjectCreator',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->orderBy('i.nameSlug', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => false,
                ))
            ->add('language', 'language', array(
                    'required' => false,
                    'label' => 'manga_label_language',
                ))
            ->add('isbn10', 'text', array(
                    'required' => false,
                    'label' => 'manga_label_isbn10',
                ))
            ->add('isbn13', 'text', array(
                    'required' => false,
                    'label' => 'manga_label_isbn13',
                ))
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
