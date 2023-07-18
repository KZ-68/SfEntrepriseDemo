<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Chaque champ du formulaire à un form type qui doit être renseigné en argument
            ->add('raisonSociale', TextType::class, [
                /* Pour améliorer l'aspect design des TextType on vas utiliser une class de bootstrap,
                on met en argumant un tableau avec comme option attr, qui accepte lui aussi un tableau,
                qui prend comme option une class qui se nomme form-control*/
                'attr' => [
                    'class' => 'form-control' 
                ]
            ])
            ->add('dateCreation', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control' 
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control' 
                ]
            ])
            ->add('cp', TextType::class, [
                'attr' => [
                    'class' => 'form-control' 
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control' 
                ]
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success' 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
