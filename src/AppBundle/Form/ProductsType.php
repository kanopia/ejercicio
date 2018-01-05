<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code')
                ->add('name')
                ->add('description')
                ->add('mark')
                ->add('price')
                ->add('products_Category', EntityType::class, array(
                                            // query choices from this entity
                                            'class' => 'AppBundle:Products_Category',

                                            // use the Products_Category.name property as the visible option string
                                            'choice_label' => 'name',

                                            // used to render a select box, check boxes or radios
                                            // 'multiple' => true,
                                            // 'expanded' => true,
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
