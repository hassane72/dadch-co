<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Etude;
use App\Form\ImageEtudeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EtudeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('compagny', TextType::class, 
                $this->getConfiguration("Compagny name", "Tapez le nom de l'entrepise faisant l'objet de l'étude"))
            ->add('slug', TextType::class,
            $this->getConfiguration("Chaine URL", "Adresse web (automatique)",
            ['required' => false]))
            ->add('typeOfStudy', TextType::class,
            $this->getConfiguration("Type d'étude", "Tapez le type de l'étude"))
            ->add('subject', TextType::class, 
            $this->getConfiguration("Le sujet de l'étude", "Tapez le sujet de l'étude"))
            ->add('contenu', TextareaType::class,
            $this->getConfiguration("Contenu de l'étude", "Tapez la description ou une résumer de l'étude"))
            ->add('secteur', TextType::class, 
            $this->getConfiguration("Secteur d'étude", "Tapez le secteur de l'étude"))
            ->add('periode', TextType::class, 
            $this->getConfiguration("la periode", "Ex: 2018"))
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nomFr',
                'multiple'=>true
            ])
            ->add(
                'imageEtudes',
                CollectionType::class,
                [
                    'entry_type' => ImageEtudeType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etude::class,
        ]);
    }
}
