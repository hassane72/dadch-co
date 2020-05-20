<?php

namespace App\Controller;

use ImageUploader;
use App\Entity\Pays;
use App\Entity\Etude;
use App\Form\EtudeType;
use App\Service\PaginationService;
use App\Repository\EtudeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEtudeController extends AbstractController
{
    /**
     * @Route("/admin/etudes/{page<\d+>?1}", name="admin_etude_index")
     */
    public function index(EtudeRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Etude::class)
                   ->setPage($page);
        return $this->render('admin/etude/index.html.twig', [
        'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/etude/new", name="admin_etude_new")
     *
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $etude = new Etude();
       // $images->setUrl('http://placehold.it/100x200')
        //        ->setCaption('titre');
        $form = $this->createForm(EtudeType::class, $etude);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($etude->getImageEtudes() as $image ) {
                $image->setEtude($etude);
                $manager->persist($image);
            }
            //$blog->setCoverImage($imageUploader->uploadImageToCloudinary($form->get('brochure')->getData()));
            $manager->persist($etude);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "Les données sont on bien été enregistrée !"
            );
            return $this->redirectToRoute('admin_etude_index');
        }
        return $this->render('admin/etude/new.html.twig',['form' => $form->createView()]);
    }
    /**
     * Permet d'afficher une form edition
     * @Route("/admin/etude/{id}/edit", name="admin_etude_edit")
     * 
     * @param Etude $etude
     * @return Response
     */
    public function edit(Etude $etude, Request $request, EntityManagerInterface $manager){
        $form =$this->createForm(EtudeType::class, $etude);
        //dump($blog);
        //die();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($etude->getImageEtudes() as $image ) {
                $image->setEtude($etude);
                $manager->persist($image);
            }
            $this->addFlash(
                'success',
                "Les modifications de l'etude <strong>{$etude->getSubject()}</strong> a bien été enregistrée !"
            );
            //$blog->setCoverImage($imageUploader->uploadImageToCloudinary($form->get('brochure')->getData()));
            $manager->persist($etude);
            $manager->flush();
            return $this->redirectToRoute('admin_etude_index');
        }
        return $this->render('admin/etude/edit.html.twig', [
            'etude' => $etude,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * @Route("/admin/etude/{id}/delete", name="admin_etude_delete")
     * @param Etude $etude
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Etude $etude, EntityManagerInterface $manager) {

            $manager->remove($etude);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'etude <strong>{$etude->getSubject()}</strong> a bien été supprimer !"
            );
        return $this->redirectToRoute('admin_etude_index');
    }
}
