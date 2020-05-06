<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="home_contact")
     */
    public function index(Request $request, EntityManagerInterface $manager, ContactNotification $notify, BlogRepository $repos)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $notify->notify($contact);
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash(
                'warning',
                "Votre message a bien été envoyer !"
            );
        }
        return $this->render('contact/index.html.twig',['form' => $form->createView(),'ads' => $repos->findLastAds(3)]);
    }
}
