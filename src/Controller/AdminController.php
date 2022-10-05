<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
//---------------------------------------------------------------------------------------------------------------------------------------
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
//---------------------------------------------------------------------------------------------------------------------------------------
    #[Route('/admin/vehicules', name: 'admin_vehicules')]
    public function adminArticles(VehiculeRepository $repo, EntityManagerInterface $manager)
    {
        $colonnes=$manager->getClassMetadata(Vehicule::class)->getFieldNames();

        $articles=$repo->findAll();
        return $this->render('admin/admin_vehicules.html.twig', [
            'articles'=>$articles,
            'colonnes'=>$colonnes
        ]);
    }



}
