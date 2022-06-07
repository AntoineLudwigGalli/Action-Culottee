<?php

namespace App\Controller;

use App\Entity\FutureEvent;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/", name: "main_")]
class MainController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/agenda/', name: 'agenda')]
    public function agenda(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $eventRepo = $doctrine->getRepository(FutureEvent::class);
        $events = $eventRepo->findBy(
            [],
            ['eventDate' => 'ASC'],
            $this->getParameter("app.events.event_number_on_agenda"),
        );


        // Quand l'évènement dépasse la date du jour, il est supprimé
        foreach($events as $event){
            if ($event->getEventDate() < new \DateTime()){
                $em = $doctrine->getManager();
                $em->remove($event);
                $em->flush();
            }
        }

        $requestedPage = $request->query->getInt('page', 1);

        // Si le numéro de page demandé dans l'url est inférieur à 1, erreur 404
        if($requestedPage < 1){
            throw new NotFoundHttpException();
        }

        $em = $doctrine->getManager();

        $query = $em->createQuery('SELECT a FROM App\Entity\FutureEvent a');

        // On stocke dans $articles les 10 articles de la page demandée dans l'URL
        $events = $paginator->paginate(
            $query,     // Requête de selection des articles en BDD
            $requestedPage,     // Numéro de la page dont on veux les articles
            4      // Nombre d'articles par page
        );


        return $this->render('main/agenda.html.twig', [
            'controller_name' => 'MainController',
            'events' => $events

        ]);
    }
}
