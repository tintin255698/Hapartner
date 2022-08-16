<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{

    public $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('name', TextType::class)
            ->add('business', TextType::class, ['label' => 'Entreprise<span class="badge rounded-pill bg-success">Facultatif</span>','label_html'=>true, 'required' => false,  'attr'=>['placeholder'=>'Votre entreprise']])
            ->add('email', EmailType::class, ['label' => 'Email',   'attr'=>['placeholder'=>'Votre email']] )
            ->add('telephone', TelType::class, ['label' => 'Téléphone',  'attr'=>['placeholder'=>'Votre téléphone']])
            ->add('sujet', ChoiceType::class, [
                'choices'  => [
                    'Audit' => 'Audit',
                    'Transformation/ Management de Transition' => 'Transformation/ Management de Transition',
                    'Support Opérationnel' => 'Support Opérationnel',
                    'Support Contractuel' => 'Support Contractuel',
                    'Autre' => 'Autre',
                ] , 'translation_domain' => 'contact' ])
            ->add('content', TextareaType::class)
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
