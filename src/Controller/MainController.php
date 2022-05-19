<?php

namespace App\Controller;

use App\Entity\FutureEvents;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function agenda(ManagerRegistry $doctrine): Response
    {

        $eventsRepo = $doctrine->getRepository(FutureEvents::class);
        $events = $eventsRepo->findBy(
            [],
            ['eventDate' => 'ASC'],
            $this->getParameter("app.events.event_number_on_agenda"),
        );


        return $this->render('main/agenda.html.twig', [
            'controller_name' => 'MainController',
            'events' => $events
        ]);
    }

    private function getRepository(string $class)
    {
    }
}
