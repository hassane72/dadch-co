<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    /**
     * @Route("/a-propos", name="a_propos")
     */
    public function index(BlogRepository $repos)
    {
        return $this->render('about/index.html.twig',['ads' => $repos->findLastAds(3)]);
    }
}
