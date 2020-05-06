<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Search;
use App\Entity\Comment;
use App\Form\SearchType;
use App\Form\CommentType;
use App\Service\PaginationFront;
use App\Repository\BlogRepository;
use App\Repository\TypeBlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page<\d+>?1}", name="blog")
     */
    public function index(TypeBlogRepository $repo,BlogRepository $repos, $page, PaginationFront $pagination)
    {
        $typeBlog = $repo->findAll();
        $pagination->setEntityClass(Blog::class)
                   ->setPage($page);
        return $this->render('blog/index.html.twig', [
            'pagination' => $pagination,
            'types' => $typeBlog,
            'ads' => $repos->findLastAds(3)
        ]);
    }
    /**
     * Undocumented function
     *
     * @Route("/blog/search", name="blog_search")
     *
     * @param Request $request
     * @return Reponse
     */
    public function search(Request $request, BlogRepository $repo){
        $slug = $request->query->get('search');
        if($repo->findLikeSlug($slug) != null){
        return $this->redirectToROute('blog_show', [
            'slug' => $repo->findLikeSlug($slug)[0]->getSlug()
        ]);
        }else{
            return $this->render('blog/error404.html.twig');
        }
    }

    /**
     * Permet d'afficher une seule annonce
     * @Route("/blog/{slug}", name="blog_show")
     *@param Blog $blog
     * @return Response
     */
    public function show(Blog $blog, TypeBlogRepository $repo,BlogRepository $repos, Request $request, EntityManagerInterface $manager) {
        $typeBlog = $repo->findAll();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setBlog($blog);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                "Votre commentaire a éte bien pris compte");
        }
        return $this->render('blog/show.html.twig',
        [
        'ad' => $blog,
        'types' => $typeBlog,
        'ads' => $repos->findLastAds(3),
        'form' => $form->createView()
        ]
    );
    }
    
}
