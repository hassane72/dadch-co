<?php

namespace App\Form;

use App\Entity\Contact;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Saisissez votre nom"))
            ->add('prenom',TextType::class, $this->getConfiguration("Prenom", "Saisissez votre pénom"))
            ->add('tel', TextType::class, $this->getConfiguration("Tél", "Saisissez votre numéro de tél"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Saisissez votre email"))
            ->add('sujet', TextType::class, $this->getConfiguration("Sujet", "Saisissez l'objet du message"))
            ->add('message', TextareaType::class, $this->getConfiguration("Message", "Saisissez votre Message"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
