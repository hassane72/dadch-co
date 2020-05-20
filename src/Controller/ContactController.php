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
        if($form->isSubmitted() && $form->isValid() && $this->captchaverify($request->get('g-recaptcha-response'))){
            $notify->notify($contact);
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash(
                'warning',
                "Votre message a bien été envoyer, consulter votre boite mail pour accuser réception !"
            );
        }
        elseif($form->isSubmitted() && $form->isValid() && !$this->captchaverify($request->get('g-recaptcha-response'))) {
                 
            $this->addFlash(
                'warning',
                'Captcha Require'
              );             
            }
        return $this->render('contact/index.html.twig',['form' => $form->createView(),'ads' => $repos->findLastAds(3)]);
    }

    public function captchaverify($recaptcha){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ["secret"=>"6LecHvMUAAAAAMIaCUcHGruwAH6Q2DNVsV2WpNjW","response"=>$recaptcha]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);     
    
    return $data->success;        
}

}
