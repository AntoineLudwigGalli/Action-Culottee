<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Entity\User;
use App\Form\CreateShopFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/user", name: "user_panel_")]
class UserPanelController extends AbstractController
{
    #[Route('/creer-une-boutique', name: 'shop_creation')]
//    TODO: Penser à activer le role user sur cette page une fois les roles créés et les tests terminés
//    #[isGranted('ROLE_USER')]
    public function createShop(ManagerRegistry $doctrine, Request $request, ): Response
    {

        $shop = new Shop();

        $form = $this->createForm(CreateShopFormType::class, $shop);

       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shop->setOwner($this->getUser());

            $em = $doctrine->getManager();
            $em->persist($shop);
            $em->flush();

            $this->addFlash('success', 'Boutique ajoutée avec succès');
        }

        return $this->render('user_panel/shop_creation.html.twig', [
            'form' => $form->createView()
        ]);
    }
}