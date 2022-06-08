<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType ::class, [
                'label' => 'Description'
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur'
            ])
            ->add('kind', TextType::class, [
                'label' => 'Genre'
            ])
            ->add('ReleaseDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'label' => 'Date de parution'
            ])
            ->add('CoverImage', FileType::class, [
                'label' => 'Image de couverture',
                'mapped' => false,
            ])
            ->add('Available', CheckboxType::class, [
                'label' => 'Disponible'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
