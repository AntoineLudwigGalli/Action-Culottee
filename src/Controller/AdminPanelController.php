<?php

namespace App\Controller;


use App\Entity\FutureEvents;
use App\Form\CreateEventFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin", name: "admin_")]
class AdminPanelController extends AbstractController
{
    #[Route('/creer-un-evenement', name: 'event')]
    public function createEvent(ManagerRegistry $doctrine, Request $request): Response
    {

        // Création d'une nouvelle instance de la classe FutureEvents
        $newEvent = new FutureEvents();

        $form = $this->createForm(CreateEventFormType::class, $newEvent);

        // Symfony va remplir $newEvent grâce aux données du formulaire envoyé
        $form->handleRequest($request);

        $newEvent = $form ->getData();

        if($form->isSubmitted() && $form->isValid()){

            // récupération du manager des entités et sauvegarde en BDD de $newArticle
            $em = $doctrine->getManager();

            $em->persist($newEvent);

            $em->flush();
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('admin_event.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
