<?php

namespace App\Controller;


use App\Entity\FutureEvent;
use App\Entity\Shop;
use App\Entity\User;
use App\Form\CreateEventFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin", name: "admin_panel_")]
class AdminPanelController extends AbstractController
{

    #[Route('/creer-un-evenement', name: 'event')]
    public function createEvent(ManagerRegistry $doctrine, Request $request): Response
    {

        // Création d'une nouvelle instance de la classe FutureEvent
        $newEvent = new FutureEvent();

        $form = $this->createForm(CreateEventFormType::class, $newEvent);

        // Symfony va remplir $newEvent grâce aux données du formulaire envoyé
        $form->handleRequest($request);

        $newEvent = $form ->getData();

        if($form->isSubmitted()){

            if(!$form->isValid()){
                $this->addFlash("error", "La création de l'évènement a échoué, veuillez ré-essayer.");
            } else {
                // récupération du manager des entités et sauvegarde en BDD de $newArticle
                $em = $doctrine->getManager();

                $em->persist($newEvent);

                $em->flush();

                //Ajout message flash
                $this->addFlash("success", "Évènement créé avec succès !");
            }
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('admin_panel/admin_event.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/creer-une-boutique', name: 'shop')]
    public function createShop(ManagerRegistry $doctrine, Request $request, ): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        $ownerOfNewShop = $userRepository->findOneById(3);

        $shop = new Shop();

        $shop
            ->setName('Test')
            ->setAddress('5 les prés hauts')
            ->setZip('21150')
            ->setCity('Pouillenay')
            ->setCountry('France')
            ->setOwner($ownerOfNewShop)
        ;

        $em = $doctrine->getManager();
        $em->persist($shop);
        $em->flush();


        return $this->redirectToRoute('main_home');
    }
}
