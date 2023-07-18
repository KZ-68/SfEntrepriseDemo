<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityRepository;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    // public function index(EntityManagerInterface $entityManager): Response
    public function index(EmployeRepository $employeRepository): Response
    {
        // $employes = $entityManager->getRepository(Employe::class)->findAll();
        // $employes = $employeRepository->findAll();
        /* Le premier argument permet de choisir ce que l'on souhaite afficher, cela équivaut à un 
        "SELECT"
        Le second argument du findBy équivaut à "SELECT * FROM employe ORDER BY nom ASC" */
        $employes = $employeRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    }

    // Pour afficher un élément par rapport à un indentifiant, il faut ajouter dans l'url de la route '/{id}'
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response 
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
        ]);
    }
}
