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
    #[isGranted('ROLE_MEMBER')]
    public function createShop(ManagerRegistry $doctrine, Request $request, ): Response
    {

        $shop = new Shop();

        $form = $this->createForm(CreateShopFormType::class, $shop);

       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shop->setOwner($this->getUser()); // On récupère l'id de l'utilisateur connecté pour y associer la
            // boutique qu'il a créé

            //  Avec l'aPI Nominatim, on récupère la latitude et la longitude de la boutique grâce à l'adresse saisie et
            // présente en bdd.

            $address = $shop->getAddress()." ". $shop->getZip(). " " . $shop->getCity() . " " . $shop->getCountry();

            $prepAddr = str_replace(' ','+',$address);

            $referer = "https://nominatim.openstreetmap.org/search?q='.$prepAddr.'&format=json"; // La connexion à
            // l'API nominatim requière de passer par le referer (un paramètre du header dans le navigateur)
            $opts = array(
                'http'=>array(
                    'header'=>array("Referer: $referer\r\n")
                )
            );
            $context = stream_context_create($opts);
            $geocode = file_get_contents($referer, false, $context);

            $output = json_decode($geocode);

            dump($output);

            $latitude = $output[0]->lat;
            $longitude = $output[0]->lon;

            $shop->setLatitude($latitude);
            $shop->setLongitude($longitude);


            $em = $doctrine->getManager();
            $em->persist($shop);
            $em->flush();

            $this->addFlash('success', 'Boutique ajoutée avec succès');
        }

        return $this->render('user_panel/shop_creation.html.twig', [
            'createShopForm' => $form->createView(),
        ]);
    }
}
