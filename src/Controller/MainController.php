<?php

namespace App\Controller;

use App\Entity\FutureEvent;


use App\Entity\DynamicContent;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route("/", name: "main_")]
class MainController extends AbstractController {

    #[Route('/', name: 'home')]
    public function home(ManagerRegistry $doctrine, Request $request): Response {
        $homePresentationRepo = $doctrine->getRepository(DynamicContent::class);
        $homePresentation = $homePresentationRepo->findOneBy([],);


        return $this->render('main/home.html.twig', ['controller_name' => 'MainController', 'homePresentation' => $homePresentation,]);
    }

    #[Route('/agenda/', name: 'agenda')]
    public function agenda(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response {
        //  On récupère les évènements triés par date de la plus récente à la plus
        // lointaine
        $eventRepo = $doctrine->getRepository(FutureEvent::class);
        $events = $eventRepo->findBy([], ['eventDate' => 'ASC'], $this->getParameter("app.events.event_number_on_agenda"),);


        // Quand l'évènement dépasse la date du jour, il est supprimé
        foreach ($events as $event) {
            if ($event->getEventDate() < new \DateTime()) {
                $em = $doctrine->getManager();
                $em->remove($event);
                $em->flush();
            }
        }

        $requestedPage = $request->query->getInt('page', 1);

        // Si le numéro de page demandé dans l'url est inférieur à 1, erreur 404
        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $em = $doctrine->getManager();

        $query = $em->createQuery('SELECT a FROM App\Entity\FutureEvent a ORDER BY a.eventDate ASC');

        // On stocke dans $articles les 10 articles de la page demandée dans l'URL
        $events = $paginator->paginate($query,     // Requête de selection des articles en BDD
            $requestedPage,     // Numéro de la page dont on veux les articles
            4      // Nombre d'articles par page
        );


        return $this->render('main/agenda.html.twig', ['controller_name' => 'MainController', 'events' => $events

        ]);
    }

    #[Route('/partenaires/', name: 'partners')]
    public function partners(): Response {


        return $this->render('main/partner.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

//    Page qui somme nous

    #[Route('/qui-sommes-nous', name: 'about')]
    public function about(ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('main/about.html.twig');
    }

}

//    Profil utilisateur

// #[Route('/profil', name: 'profil')]
// #[IsGranted('ROLE_USER')]
// public function profil()
// {
    // Si la personne qui essaye de venir sur cette page n'est pas connectée, elle sera redirigée à la page de connexion par le firewall

//    return $this->render('main/profil.html.twig');
// }


//    Panneau d'administration

// #[Route('/administration', name: 'admin')]
// #[IsGranted('ROLE_ADMIN')]
// public function admin()
// {
    // Si la personne qui essaye de venir sur cette page n'a pas le rôle ROLE_ADMIN, elle sera redirigée à la page de connexion si elle n'est pas connecté ou bien sur une page 403 si elle l'est mais n'est pas admin.

//    return $this->render('main/admin.html.twig');
// }
