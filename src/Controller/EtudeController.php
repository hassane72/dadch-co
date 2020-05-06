<?php

namespace App\Controller;

use App\Entity\Etude;
use App\Service\PaginationFront;
use App\Repository\BlogRepository;
use App\Repository\PaysRepository;
use App\Repository\EtudeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtudeController extends AbstractController
{
    /**
     * @Route("/etude/{page<\d+>?1}", name="etude")
     */
    public function index(PaysRepository $repo, $page, PaginationFront $pagination, EtudeRepository $repos, BlogRepository $reposi)
    {
        $pays = $repo->findAll();
        $pagination->setEntityClass(Etude::class)
                   ->setPage($page);
        return $this->render('etude/index.html.twig', [
            'pagination' => $pagination,
            'pays' => $pays,
            'etudes' => $repos->findLastEtudes(3),
            'ads' => $reposi->findLastAds(3)
        ]);
    }
    /**
     * Undocumented function
     *
     * @Route("/etude/search", name="etude_search")
     *
     * @param Request $request
     * @return Reponse
     */
    public function search(Request $request, EtudeRepository $repo){
        $slug = $request->query->get('search');
        if($repo->findLikeSlug($slug) != null){
        return $this->redirectToROute('blog_show', [
            'slug' => $repo->findLikeSlug($slug)[0]->getSlug()
        ]);
        }else{
            return $this->render('etude/error404.html.twig');
        }
    }

    /**
     * Permet d'afficher une seule etude
     * @Route("/etude/{slug}", name="etude_show")
     *@param Etude $etude
     * @return Response
     */
    public function show(Etude $etude, PaysRepository $repo, EtudeRepository $repos, BlogRepository $reposi) {
        $pays = $repo->findAll();
        return $this->render('etude/show.html.twig',
        [
        'etude' => $etude,
        'pays' => $pays,
        'etudes' => $repos->findLastEtudes(3),
        'ads' => $reposi->findLastAds(3)
        ]
    );
    }
}
