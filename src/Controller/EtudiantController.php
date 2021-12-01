<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant")
     */
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }

    /**
     * @Route("/addEtudiant", name="addEtudiant")
     */
    public function addEtudiant(Request $request, ManagerRegistry $doctrine): Response
    {
        $etudiant = new Etudiant();
       
        $form = $this->createForm(EtudiantFormType::class,$etudiant);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $etudiant = $form->getData();
            //dump($fan);

            $em = $doctrine->getManager();
            $em->persist($etudiant);
            $em->flush();

            $repo = $doctrine->getManager()->getRepository(Etudiant::class);

            $liste_etudiant = $repo->findAll();
    
            return $this->render('etudiant/show.html.twig', [
                'controller_name' => 'EtudiantController',
                'liste_etudiant' => $liste_etudiant
            ]);
            
        }

        return $this->renderForm("etudiant/index.html.twig",
        ["formulaire" => $form]
        );

    }

    /**
     * @Route("/showEtudiant/", name="showEtudiant")
     */
    public function showEtudiant(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getManager()->getRepository(Etudiant::class);

        $liste_etudiant = $repo->findAll();

        return $this->render('etudiant/show.html.twig', [
            'controller_name' => 'EtudiantController',
            'liste_etudiant' => $liste_etudiant
        ]);

    }

    /**
     * @Route("/editEtudiant/{id}", name="editEtudiant")
     */
    public function editEtudiant(Request $request, ManagerRegistry $doctrine, int $id ): Response
    {
        $repo = $doctrine->getManager()->getRepository(Etudiant::class);

        $etudiant = $repo->find($id);

        //$etudiant = new Etudiant();
       
        $form = $this->createForm(EtudiantFormType::class,$etudiant);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $etudiant = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($etudiant);
            $em->flush();

            $repo = $doctrine->getManager()->getRepository(Etudiant::class);

            $liste_etudiant = $repo->findAll();
    
            return $this->render('etudiant/show.html.twig', [
                'controller_name' => 'EtudiantController',
                'liste_etudiant' => $liste_etudiant
            ]);
            
        }

        return $this->renderForm("etudiant/edit.html.twig",
        ["formulaire" => $form]
        );


    }

}
