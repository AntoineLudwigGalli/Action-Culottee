<?php

namespace App\Controller;

use App\Entity\DynamicContent;
use App\Entity\Shop;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    #[Route('/ajax/shops', name: 'app_ajax_shops')]
    public function jsonAction(ManagerRegistry $doctrine): JsonResponse
    {
//On récupère dans la BDD les adresses des boutiques et on les convertit en page JSON
        $shopAddressRepository = $doctrine->getRepository(Shop::class);
        $shopAddresses = $shopAddressRepository->findAll();
// Todo: faire la gestion des erreurs
        foreach ($shopAddresses as $shopAddress){
            $name = $shopAddress->getName();
            $phoneNumber = $shopAddress->getPhoneNumber();
            $address = $shopAddress->getAddress();
            $zipcode = $shopAddress->getZip();
            $city = $shopAddress->getCity();
            $country = $shopAddress->getCountry();
            $latitude = $shopAddress->getLatitude();
            $longitude = $shopAddress->getLongitude();

            /**
             * Mon tableau de données pour les marqueurs sur la carte
             */
            $data[] = [
                    "name" => $name,
                    "phoneNumber" => $phoneNumber,
                    "address" => $address,
                    "zipcode" => $zipcode,
                    "city" => $city,
                    "country" => $country,
                    "latitude" => $latitude,
                    "longitude" => $longitude,

            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/ajax/partners', name: 'app_ajax_partners')]
    public function jsonPartners(ManagerRegistry $doctrine): JsonResponse
    {
//On récupère dans la BDD les adresses des boutiques et on les convertit en page JSON
        $partnerDynamicContentRepository = $doctrine->getRepository(DynamicContent::class);
        $partnerDynamicContents = $partnerDynamicContentRepository->findAll();

// Todo: faire la gestion des erreurs
        foreach ($partnerDynamicContents as $partnerDynamicContent){
            $id = $partnerDynamicContent->getId();
            $name = $partnerDynamicContent->getName();
            $content = $partnerDynamicContent->getContent();

            /**
             * Mon tableau de données pour les marqueurs sur la carte
             */
            $data[] = [
                "id" => $id,
                "name" => $name,
                "content" => $content,

            ];
        }

        return new JsonResponse($data);
    }
}
