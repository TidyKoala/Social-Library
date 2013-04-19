<?php

namespace SocialLibrary\ReadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pictureFile', 'file', array(
                    'required' => false,
                    'label' => 'label_book_picture',
                ))
            ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'label_book_name',
                ))
            ->add('volume', 'integer', array(
                    'required' => false,
                    'label' => 'label_book_volume',
                ))
            ->add('serie', 'entity', array(
                    'required' => false,
                    'label' => 'label_book_serie',
                    'class' => 'SocialLibrary\ReadBundle\Entity\Serie',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->orderBy('s.nameSlug', 'ASC');
                    },
                    'multiple' => false,
                ))
            ->add('creators', 'entity', array(
                    'required' => true,
                    'label' => 'label_book_creators',
                    'class' => 'SocialLibrary\BaseBundle\Entity\ObjectCreator',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.nameSlug', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => false,
                ))
            ->add('language', 'language', array(
                    'required' => false,
                    'label' => 'label_book_language',
                    'empty_value' => 'placeholder_book_language',
                ))
            ->add('isbn10', 'text', array(
                    'required' => false,
                    'label' => 'label_book_isbn10',
                ))
            ->add('isbn13', 'text', array(
                    'required' => false,
                    'label' => 'label_book_isbn13',
                ))
        ;
    }

    public function getName()
    {
        return 'book';
    }
}
