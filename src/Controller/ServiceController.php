<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/services", name="home_service")
     */
    public function index(BlogRepository $repos)
    {
        return $this->render('service/index.html.twig',[
            'ads' => $repos->findLastAds(3)
        ]);
    }
     /**
     * @Route("/services/methodologie", name="home_service_methode")
     */
    public function methode(BlogRepository $repos)
    {
        return $this->render('service/methodologie.html.twig',[
            'ads' => $repos->findLastAds(3)
        ]);
    }
}
