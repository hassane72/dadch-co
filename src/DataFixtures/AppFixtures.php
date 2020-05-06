<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Blog;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\TypeBlog;
use App\Entity\ImageBlog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-Fr');
        $typeBlogs = [];
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        
        $adminUser = new User();
        $adminUser->setFirstName('admin')
                  ->setLastName('dadch')
                  ->setEmail('admin@dadch.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->setPicture('https://randomuser.me/api/portraits/med/men/2.jpg')
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);
        $typeBlog = new TypeBlog();
        $typeBlog->setName('Actualité');
        $manager->persist($typeBlog);
        $typeBlogs[] = $typeBlog;
        $typeBlog = new TypeBlog();
        $typeBlog->setName('Bulletins d\'enquête');
        $manager->persist($typeBlog);
        $typeBlogs[] = $typeBlog;
        //Nous gerons les annonces
        for($i = 1; $i <= 30; $i++){
            $ad = new Blog();
            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';
            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContenu($content)
                ->setAuthor($adminUser);
            $typeBlog = $typeBlogs[mt_rand(0, count($typeBlogs) - 1)];
            $ad->setTypeBlog($typeBlog);
            for($j=1; $j<=mt_rand(2,5); $j++){
                $image = new ImageBlog();
                $image->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setBlog($ad);
                $manager->persist($image);
            }
             //Gestion des comments
             for($j = 1; $j <= mt_rand(0, 5); $j++){
                $comment = new Comment();
                $comment->setContenu($faker->paragraph())
                        ->setRating(mt_rand(1,5))
                        ->setFirstName($faker->firstname)
                        ->setLastName($faker->lastname)
                        ->setEmail($faker->email)
                        ->setBlog($ad);
                $manager->persist($comment);
            }
            $manager->persist($ad);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
