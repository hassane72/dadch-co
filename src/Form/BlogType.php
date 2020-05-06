<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\TypeBlog;
use App\Form\ImageBlogType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BlogType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                  $this->getConfiguration("Titre", "Tapez un super titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Chaine URL", "Adresse web (automatique)",
                  ['required' => false]))
            ->add('introduction', TextType::class,
                   $this->getConfiguration("Introduction", "Donnez une description globale de l'annonce"))
            ->add('contenu', TextareaType::class, 
                   $this->getConfiguration("Description detaillée", "Tapez une description pour votre annonce !"))
           // ->add('brochure', FileType::class, [
           //     'label' => 'Files test',
           //     'mapped' => false,
           //     'required' => false
           // ])
           // ->add('imageFile', FileType::class, ['required' => false])
           ->add('coverImage',
                   UrlType::class, 
                   $this->getConfiguration("Url de l'image principale", "Donnez l'adresse d'une image qui donne vraiment envie"))
            ->add('typeBlog', EntityType::class, [
                'class' => TypeBlog::class,
                'choice_label' => 'name'
            ])
            ->add(
                'imageBlogs',
                CollectionType::class,
                [
                    'entry_type' => ImageBlogType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
