<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    /* La route est le chemin de l'url (ex: 127.0.0.1:8000/entreprise) suivis d'un name 
    (ex : app_entreprise) pour afficher les éléments contenus dans la fonction,
    le name ne peut avoir un autre même nom identique, au risque de causer des problèmes de redirections */ 
    #[Route('/entreprise', name: 'app_entreprise')]
    // public function index(EntityManagerInterface $entityManager): Response
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
        // $entreprises = $entrepriseRepository->findAll();
        
        /* Le premier argument filtre ce que l'on souhaite afficher, cela équivaut à un 
        "SELECT * FROM entreprise WHERE ville = 'STRASBOURG' ORDER BY raisonSociale ASC"
        Le second argument du findBy équivaut à "SELECT * FROM entreprise ORDER BY raisonSociale ASC" */
        $entreprises = $entrepriseRepository->findBy([], ["raisonSociale" => "ASC"]);
        // Affiche sur la view donnée en premier argument, les éléments présents dans le tableau en second argument
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }

    #[Route('/entreprise/new', name: 'new_entreprise')]
    // Route pour éditer une entreprise par son id
    #[Route('/entreprise/{id}/edit', name: 'edit_entreprise')]
    public function new_edit(Entreprise $entreprise = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // La valeur de $entreprise est null par défaut, si l'entreprise n'existe pas, on met une nouvelle Entreprise comme valeur
        if (!$entreprise) {
            $entreprise = new Entreprise();
        }
        
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() retient les valeurs soumises
            // mais la variable $entreprise est également mise à jour
             $entreprise = $form->getData();
            
            /* persist dit à Doctrine de sauvegarder dans une instance l'objet en argument,
            équivaut à un prepare PDO */
            $entityManager->persist($entreprise);

            // Exécute la requête, équivaut à execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_entreprise');
        }

        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
            'edit' => $entreprise->getId()
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(Entreprise $entreprise, EntityManagerInterface $entityManager) {
        $entityManager->remove($entreprise);
        $entityManager->flush();

        return $this->redirectToRoute('app_entreprise');
    }

    // Pour afficher un élément par rapport à un indentifiant, il faut ajouter dans l'url de la route '/{id}'
    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response 
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}
