<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;


class ProductsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', null, array(
                                'label' => 'Codigo',
                                'required' => true,
                                'attr' => array('maxlength' => 10,
                                                'minlength' => 4),
                            ))
                ->add('name', null, array(
                                'label' => 'Nombre',
                                'required' => true,
                                'attr' => array('minlength' => 4,),
                            ))
                ->add('description', null, array(
                                'label' => 'Descripción',
                                'required' => true,
                            ))
                ->add('mark', null, array(
                                'label' => 'Marca',
                                'required' => true,
                            ))
                ->add('price', null, array(
                                'label' => 'Precio',
                                'required' => true,
                                'attr'  =>  array('type' => 'float'),
                            ))
                ->add('products_Category', EntityType::class, array(
                                            // query choices from this entity
                                            'class' => 'AppBundle:Products_Category',

                                            // use the Products_Category.name property as the visible option string
                                            'choice_label' => 'nameCat',
                                            'label'     =>  'Categorias',
                                            'required' => true,
                                        ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Products'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_products';
    }


}
