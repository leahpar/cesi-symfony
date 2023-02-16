<?php

namespace App\Form;

use App\Entity\Planete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class PlaneteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'nom',
                ]
            ])
            ->add('taille', NumberType::class, [
                'required' => true,
                'html5' => true,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ],
                'attr' => [
                    'placeholder' => 'taille',
                ]
            ])
            ->add('distance', NumberType::class, [
                'required' => true,
                'html5' => true,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ],
                'attr' => [
                    'placeholder' => 'distance',
                ]
            ])
            ->add('name', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'name',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planete::class,
        ]);
    }
}
