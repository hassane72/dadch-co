<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {


    /**
     * Affichage de la page d'accueil
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function home(BlogRepository $repos) {
        return $this->render('home.html.twig', [
            'ads' => $repos->findLastAds(3)
        ]);
    }
    

}