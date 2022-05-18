<?php

namespace App\Controller;

use App\Entity\FutureEvents;
use App\Repository\FutureEventsRepository;
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
        $em = $doctrine->getManager();
        $events = $em->getRepository(FutureEvents::class)->findAll();


        return $this->render('main/agenda.html.twig', [
            'controller_name' => 'MainController',
            'events' => $events

        ]);
    }
}
