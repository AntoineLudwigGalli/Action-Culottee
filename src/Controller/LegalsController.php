<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/legals", name: "legals_")]
class LegalsController extends AbstractController
{
    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response
    {

        return $this->render('legals/cgu.html.twig');
    }

    #[Route('/mentions-legales', name: 'legal_mentions')]
    public function legal_mentions(): Response
    {

        return $this->render('legals/legal_mentions.html.twig');
    }
}
