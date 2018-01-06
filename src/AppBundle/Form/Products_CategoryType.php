<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Products_CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', null, array(
                                'label' => 'Codigo',
                                'required' => true,
                            ))
                ->add('nameCat', null, array(
                                'label' => 'Nombre',
                                'required' => true,
                                'attr' => array('minlength' => 2),
                            ))
                ->add('description', null, array(
                                'label' => 'Descripción',
                                'required' => true,
                            ))
                ->add('active', null, array(
                                'label' => 'Activo',
                            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Products_Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_products_category';
    }


}
