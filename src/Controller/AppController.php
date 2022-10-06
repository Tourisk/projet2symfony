<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeFormType;
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
public function appShow($id, VehiculeRepository $repo): Response
{
    $vehicule=$repo->find($id);
    return $this->render('app/show.html.twig', [
        'show'=> $vehicule
    ]);
}

#[Route('/commande/new', name: 'reservation')]
public function adminFormVehicule($id, VehiculeRepository $repo, Request $globals, EntityManagerInterface $manager, Commande $commande = null)
{
    $reservations=$repo->find($id);
    if($commande == null) {
        $commande= new Commande;
        $commande->setDateEnregistrement(new \DateTime);
    }

    $form=$this->createForm(CommandeFormType::class, $commande);

    $form->handleRequest($globals);

    if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($commande);
        $manager->flush();
        $this->addFlash('success', "Le véhicule a bien été édité / enregistré !");

        return $this->redirectToRoute('admin_vehicules');
    }
    return $this->renderForm('app/commandes.html.twig', [
        'form'=> $form,
        'reservations' => $reservations
    ]);
   
    return ;
}





//---------------------------------------------------------------------------------------------------------------------------------------











//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
//show id details + formulaire de reservation
//profils avec historique de commande
// #[Route('/commande', name: 'commande')]
// #[Route('/commande/new', name: 'new_commande')]
// public function adminFormVehicule(CommandeRepository $repo, Request $globals, EntityManagerInterface $manager, Commande $commande = null)
// {
//     $commandes=$repo->findAll();
//     if($commande == null) {
//         $commande= new Commande;
//         $commande->setDateEnregistrement(new \DateTime);
//     }

//     $form=$this->createForm(CommandeFormType::class, $commande);

//     $form->handleRequest($globals);

//     if($form->isSubmitted() && $form->isValid()) {
//         $manager->persist($commande);
//         $manager->flush();
//         $this->addFlash('success', "La commande a bien été enregistré !");

//         //changer vers l'historique ou profil
//         return $this->redirectToRoute('commande');
//     }
//     return $this->renderForm('app/commande.html.twig', [
//         'form'=> $form,
//         'commandes' => $commandes,
//         'editMode'=> $commande->getId() !== null
//     ]);
   
//     return ;
// }


}
