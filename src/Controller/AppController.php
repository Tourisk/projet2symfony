<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeFormType;
use App\Repository\MembreRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/', name: 'app_index')]
public function indexApp(VehiculeRepository $repo): Response
{
    $show_all=$repo->findAll();
   
    return $this->renderForm('app/index.html.twig', [
        'shows' => $show_all
    ]);
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/show/{id}', name: 'app_show')]
public function appShow($id, VehiculeRepository $repo, Request $globals, EntityManagerInterface $manager, Commande $commande = null): Response
{
    $vehicule=$repo->find($id);

    if($commande == null) {
        $commande= new Commande;
        $commande->setDateEnregistrement(new \DateTime);
    }

    $form=$this->createForm(CommandeFormType::class, $commande);

    $form->handleRequest($globals);

    if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($commande);
        $manager->flush();
        $this->addFlash('success', "Le véhicule a bien été réserver !");

        return $this->redirectToRoute('app_index');
    }
    return $this->renderForm('app/show.html.twig', [
        'formCommande'=> $form,
        'show'=> $vehicule
    ]);
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/membre/{id}', name: 'app_membre')]
public function appMembre($id, MembreRepository $repo): Response
{
    $membre=$repo->find($id);
    return $this->render('app/membre.html.twig', [
        'membre'=> $membre
    ]);
}
//---------------------------------------------------------------------------------------------------------------------------------------

}
