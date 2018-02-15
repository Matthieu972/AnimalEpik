<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('height')
            ->add('weight')
            ->add('location')
            ->add('description')
            ->add('category',
                EntityType::class, [
                    'class'         =>  'AppBundle\Entity\Category',
                    'choice_label'  =>  'name'
                ])
            ->add('conveyance',
                EntityType::class, [
                    'class' =>  'AppBundle\Entity\Conveyance',
                    'choice_label'  =>  'name'
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Animal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_animal';
    }


}
