<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/home", name="admin_dashboard")
     * 
     */
    public function index(EntityManagerInterface $manager, StatsService $statsService)
    {
        $stats      = $statsService->getStats();
        $bestAds    = $statsService->getAdsStats('DESC');
        $worstAds   = $statsService->getAdsStats('ASC');
        return $this->render('admin/index.html.twig',[
            'stats'     => $stats,
            'bestAds'   => $bestAds,
            'worstAds'  => $worstAds
        ]);
    }
}
