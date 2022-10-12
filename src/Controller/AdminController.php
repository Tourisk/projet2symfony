<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Vehicule;
use App\Form\MembreFormType;
use App\Form\VehiculeFormType;
use App\Repository\MembreRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
//---------------------------------------------------------------------------------------------------------------------------------------
    #[Route('/admin', name: 'app_admin')]
    public function adminIndex(): Response
    {
        return $this->render('admin/index.html.twig');
    }
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/admin/vehicules', name: 'admin_vehicules')]
#[Route('/admin/vehicule/new', name: 'admin_new_vehicule')]
#[Route('/admin/vehicule/edit/{id}', name: 'admin_edit_vehicule')]
public function adminFormVehicule(VehiculeRepository $repo, Request $globals, EntityManagerInterface $manager, Vehicule $vehicule = null)
{
    $vehicules=$repo->findAll();
    if($vehicule == null) {
        $vehicule= new Vehicule;
        $vehicule->setDateEnregistrement(new \DateTime);
    }

    $form=$this->createForm(VehiculeFormType::class, $vehicule);

    $form->handleRequest($globals);

    if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($vehicule);
        $manager->flush();
        $this->addFlash('success', "Le véhicule a bien été édité / enregistré !");

        return $this->redirectToRoute('admin_vehicules');
    }
    return $this->renderForm('admin/admin_vehicules.html.twig', [
        'form'=> $form,
        'vehicules' => $vehicules,
        'editMode'=> $vehicule->getId() !== null
    ]);
   
    return ;
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/admin/vehicule/delete/{id}', name: 'admin_delete_vehicule')]
public function adminDeleteVehicule(Vehicule $vehicule, EntityManagerInterface $manager)
{
    $manager->remove($vehicule);
    $manager->flush();

    return $this->redirectToRoute('admin_vehicules');
}
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/admin/membres', name: 'admin_membres')]
#[Route('/admin/membre/new', name: 'admin_new_membre')]
#[Route('/admin/membre/edit/{id}', name: 'admin_edit_membre')]
public function adminFormMembre(MembreRepository $repo, Request $globals, EntityManagerInterface $manager, Membre $membre = null)
{
    $membres=$repo->findAll();
    if($membre == null) {
        $membre= new Membre;
        $membre->setDateEnregistrement(new \DateTime);
    }

    $form=$this->createForm(MembreFormType::class, $membre);

    $form->handleRequest($globals);

    if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($membre);
        $manager->flush();
        $this->addFlash('success', "Le membre a bien été édité / enregistré !");

        return $this->redirectToRoute('admin_membres');
    }
    return $this->renderForm('admin/admin_membres.html.twig', [
        'form'=> $form,
        'membres' => $membres,
        'editMode'=> $membre->getId() !== null
        ]);
        
    return ;
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/admin/membre/delete/{id}', name: 'admin_delete_membre')]
public function adminDeleteMembre(Membre $membre, EntityManagerInterface $manager)
{
    $manager->remove($membre);
    $manager->flush();

    return $this->redirectToRoute('admin_membres');
}
//---------------------------------------------------------------------------------------------------------------------------------------
//Commande Gestion
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------


}
