<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Brand', TextType::class)
            ->add('Model', TextType::class)
            ->add('Price', TextType::class)
            ->add('Description', TextType::class)
            ->add('Image', TextType::class)
            ->add('Image2', TextType::class)
            ->add('Accel', TextType::class)
            ->add('Puissance', TextType::class)
            ->add('TopSpeed', TextType::class)
            ->add('save', SubmitType::class);
    }
}