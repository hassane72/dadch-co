<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Entity\ImageBlog;
use App\Service\ImageUploader;
use App\Repository\BlogRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBlogController extends AbstractController
{

    /**
     * @Route("/admin/blog/{page<\d+>?1}", name="admin_blog_index")
     * 
     */
    public function blog(BlogRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Blog::class)
                   ->setPage($page);
        return $this->render('admin/blog/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/blog/new", name="admin_blog_new")
     *
     */
    public function create(Request $request, EntityManagerInterface $manager, ImageUploader $imageUploader)
    {
        $blog = new Blog();
       // $images->setUrl('http://placehold.it/100x200')
        //        ->setCaption('titre');
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($blog->getImageBlogs() as $image ) {
                $image->setBlog($blog);
                $manager->persist($image);
            }
            $blog->setAuthor($this->getUser());
            //$blog->setCoverImage($imageUploader->uploadImageToCloudinary($form->get('brochure')->getData()));
            $manager->persist($blog);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong>{$blog->getTitle()}</strong> a bien été enregistrée !"
            );
            return $this->redirectToRoute('admin_blog_index');
        }
        
        return $this->render('admin/blog/new.html.twig',['form' => $form->createView()]);
    }

    /**
     * Permet d'afficher une form edition
     * @Route("/admin/blog/{id}/edit", name="admin_blog_edit")
     * 
     * @param Blog $blog
     * @return Response
     */
    public function edit(Blog $blog, Request $request, EntityManagerInterface $manager){
        $form =$this->createForm(BlogType::class, $blog);
        //dump($blog);
        //die();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($blog->getImageBlogs() as $image ) {
                $image->setBlog($blog);
                $manager->persist($image);
            }
            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong>{$blog->getTitle()}</strong> a bien été enregistrée !"
            );
            //$blog->setCoverImage($imageUploader->uploadImageToCloudinary($form->get('brochure')->getData()));
            $manager->persist($blog);
            $manager->flush();
        }
        return $this->render('admin/blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * @Route("/admin/blog/{id}/delete", name="admin_blog_delete")
     * @param Blog $blog
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Blog $blog, EntityManagerInterface $manager) {

            $manager->remove($blog);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'annonce <strong>{$blog->getTitle()}</strong> a bien été supprimer !"
            );
        return $this->redirectToRoute('admin_blog_index');
    }
}
