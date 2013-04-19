<?php

namespace SocialLibrary\ReadBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use SocialLibrary\ReadBundle\Form\Type\BookType;

class MangaType extends BookType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('volume')
            ->add('volume', 'integer', array(
                    'required' => true,
                    'label' => 'label_book_volume',
                ))
            ->remove('serie')
            ->add('serie', 'entity', array(
                    'required' => true,
                    'label' => 'label_book_serie',
                    'class' => 'SocialLibrary\ReadBundle\Entity\Serie',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->orderBy('s.nameSlug', 'ASC');
                    },
                    'multiple' => false,
                    'empty_value' => '',
                ))
            ->add('illustrators', 'entity', array(
                    'required' => true,
                    'label' => 'label_book_illustrators',
                    'class' => 'SocialLibrary\BaseBundle\Entity\ObjectCreator',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->orderBy('i.nameSlug', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => false,
                    'empty_value' => '',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialLibrary\ReadBundle\Entity\Manga'
        ));
    }
}
