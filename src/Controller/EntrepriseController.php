<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    /* La route est le chemin de l'url pour afficher les éléments contenus dans la fonction,
    le nom (ex : app_entreprise) ne peut avoir un autre fichier avec le même nom, au risque de causer des problèmes de redirections */ 
    #[Route('/entreprise', name: 'app_entreprise')]
    // public function index(EntityManagerInterface $entityManager): Response
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
        $entreprises = $entrepriseRepository->findAll();
        // Affiche sur la view donnée en premier argument, les éléments présents dans le tableau en second argument
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }
}
