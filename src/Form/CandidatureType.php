<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom', 'attr'=>['placeholder'=>'Votre prénom']])
            ->add('name', TextType::class, ['label' => 'Nom',   'attr'=>['placeholder'=>'Votre nom']])
            ->add('experience', ChoiceType::class, [ 'label' => 'Expériences',
                'choices'  => [
                    'Moins de 1 à 3 années' => 'Moins de 1 à 3 années',
                    'De 3 à 6 années' => 'De 3 à 6 années',
                    'De 3 à 10 années' => 'De 3 à 10 années',
                    'Plus de 10 années' => 'Plus de 10 années',
                ], 'translation_domain' => 'contact' ])
            ->add('email', EmailType::class, ['label' => 'Email',   'attr'=>['placeholder'=>'Votre email']] )
            ->add('telephone', TelType::class, ['label' => 'Téléphone',  'attr'=>['placeholder'=>'Votre téléphone']])
            ->add('cv', FileType::class, ['label' => 'Curriculum Vitae'])
            ->add('lm', CKEditorType::class, ['label' => 'Lettre de motivation<span class="badge rounded-pill bg-success">Facultatif</span>','label_html'=>true, 'required' => false, 'translation_domain' => 'contact'])
            ->add('envoyer', SubmitType::class,  ['row_attr' => [
                'class' => 'text-end']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
