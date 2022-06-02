<?php

namespace App\Form;

use App\Entity\Products;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'maxLength' => 45
                ]
            ])
            ->add('description', TextAreaType::class, [
                'attr' => [
                    'maxLength' => 65535
                ]
            ])
            ->add('type')
            ->add('price', FloatType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 999.99,
                    'step' => 0.01
                ]
            ])
            ->add('created_at')
            ->add('updated_at')
            ->add('image')
            ->add('category', EntityType::class, [
                'class'=> Category::class,
                'choice_label' => 'name'
            ])
            ->add('Orders', EntityType::class, [
                'class'=> Orders::class
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
