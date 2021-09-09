<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', null, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => 'Saisissez votre nom'
                ]
            ])

            ->add('Email', EmailType::class, [
                'label' => "Email",
                'attr' => [
                    'placeholder' => 'Saisissez votre adresse mail'
                ]
            ])

            ->add('Objet', null, [
                'label' => "Objet du message",
                'attr' => [
                    'placeholder' => ''
                ]
            ])
            ->add('Message', null, [
                'label' => "Message",
                'attr' => [
                    'placeholder' => 'Entrez le corps de votre message'
                ]
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
