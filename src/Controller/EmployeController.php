<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\ORM\EntityRepository;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/employe/new', name: 'new_employe')]
    // Route pour éditer une employe par son id
    #[Route('/employe/{id}/edit', name: 'edit_employe')]
    public function new_edit(Employe $employe = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // La valeur de $employe est null par défaut, si l'employe n'existe pas, on met un nouvel Employe comme valeur
        if (!$employe) {
            $employe = new Employe();
        }

        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() retient les valeurs soumises
            // mais la variable $entreprise est également mise à jour
             $employe = $form->getData();
            
            /* persist dit à Doctrine de sauvegarder dans une instance l'objet en argument,
            équivaut à un prepare PDO */
            $entityManager->persist($employe);

            // Exécute la requête, équivaut à execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_employe');
        }

        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form,
            'edit' => $employe->getId()
        ]);
    }

    #[Route('/employe/{id}/delete', name: 'delete_employe')]
    public function delete(Employe $employe, EntityManagerInterface $entityManager) {
        // Prépare la suppression d'une instance de l'objet 
        $entityManager->remove($employe);
        // Exécute la suppression
        $entityManager->flush();

        return $this->redirectToRoute('app_employe');
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
