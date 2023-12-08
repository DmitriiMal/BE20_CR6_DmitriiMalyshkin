<?php

namespace App\Form;

use App\Entity\Events;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class EventsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, [
        'attr' => ['class' => 'form-control mb-3']
      ])


      ->add('url', TextType::class, [
        'attr' => ['class' => 'form-control mb-3']
      ])


      ->add('capacity', NumberType::class, [
        'attr' => ['class' => 'form-control mb-3']
      ])

      ->add('date', DateTimeType::class, [
        'attr' => ['class' => 'form-control mb-3']
      ])

      ->add('picture', TextType::class, [
        'attr' => ['class' => 'form-control mb-3']
      ])

      ->add('description', TextareaType::class, [
        'attr' => ['class' => 'form-control mb-3']
      ])
      ->add('save', SubmitType::class, [
        'label' => 'Submit',
        'attr' => ['class' => 'btn btn-primary mb-3']
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Events::class,
    ]);
  }
}
