<?php

namespace SocialLibrary\ReadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SerieAjaxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'serie_label_name',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialLibrary\ReadBundle\Entity\Serie'
        ));
    }

    public function getName()
    {
        return 'sociallibrary_readbundle_commonbundle_serieajaxtype';
    }
}
