<?php

namespace SocialLibrary\ReadBundle\GraphicNovelBundle\Form\Type;

use SocialLibrary\BaseBundle\Form\Type\ObjectCreatorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class GraphicNovelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pictureFile', 'file', array(
                    'required' => false,
                    'label' => 'graphic_novel_label_cover',
                ))
            ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'graphic_novel_label_name',
                ))
            ->add('volume', 'integer', array(
                    'required' => true,
                    'label' => 'graphic_novel_label_volume',
                ))
            ->add('serie', 'entity', array(
                    'required' => true,
                    'label' => 'graphic_novel_label_serie',
                    'class' => 'SocialLibrary\ReadBundle\CommonBundle\Entity\Serie',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->orderBy('s.nameSlug', 'ASC');
                    },
                    'multiple' => false,
                ))
            ->add('creators', 'entity', array(
                    'required' => true,
                    'label' => 'graphic_novel_label_creators',
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
                    'label' => 'graphic_novel_label_illustrators',
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
                    'label' => 'graphic_novel_label_language',
                ))
            ->add('isbn10', 'text', array(
                    'required' => false,
                    'label' => 'graphic_novel_label_isbn10',
                ))
            ->add('isbn13', 'text', array(
                    'required' => false,
                    'label' => 'graphic_novel_label_isbn13',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialLibrary\ReadBundle\GraphicNovelBundle\Entity\GraphicNovel'
        ));
    }

    public function getName()
    {
        return 'graphicnoveltype';
    }
}
