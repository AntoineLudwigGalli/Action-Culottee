<?php

namespace App\Controller;


use App\Entity\FutureEvent;
use App\Entity\HomePresentation;
use App\Entity\Shop;
use App\Entity\User;
use App\Form\CreateEventFormType;
use App\Form\CreateShopFormType;
use App\Form\HomePresentationFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin", name: "admin_panel_")]
class AdminPanelController
    extends
    AbstractController
{

    #[Route('/creer-un-evenement', name: 'event')]
    public function createEvent(ManagerRegistry $doctrine, Request $request): Response
    {

        // Création d'une nouvelle instance de la classe FutureEvent
        $newEvent = new FutureEvent();

        $form = $this->createForm(CreateEventFormType::class, $newEvent);

        // Symfony va remplir $newEvent grâce aux données du formulaire envoyé
        $form->handleRequest($request);

        $newEvent = $form->getData();

        if ($form->isSubmitted()) {

            if (!$form->isValid()) {
                $this->addFlash("error", "La création de l'évènement a échoué, veuillez ré-essayer.");
            }
            else {
                // récupération du manager des entités et sauvegarde en BDD de $newEvent
                $em = $doctrine->getManager();

                $em->persist($newEvent);

                $em->flush();

                //Ajout message flash
                $this->addFlash("success", "Évènement créé avec succès !");
            }
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('admin_panel/admin_event.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }


////////////////////////////////////////////////////////////////
///
    #[Route('/liste-des-evenements', name: 'events_list')]
    public function eventList(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $requestedPage = $request->query->getInt('page', 1);

        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $em = $doctrine->getManager();

        $query = $em->createQuery('SELECT a FROM App\Entity\FutureEvent a ORDER BY a.eventDate ASC');

        $events = $paginator->paginate(
            $query,
            $requestedPage,
            20,
        );

        return $this->render('admin_panel/admin_events_list.html.twig',
            [
                'events' => $events,
            ]);
    }

/////////////////////////////////////////////////////////////////////
    #[Route('/suppression-d\'un-evenement/{id}/', name: 'event_delete_', priority: 10)]
    public function eventDelete(FutureEvent $futureEvent, Request $request, ManagerRegistry $doctrine): Response
    {

        $csrfToken = $request->query->get('csrf_token', '');

        if (!$this->isCsrfTokenValid('event_delete_' . $futureEvent->getId(), $csrfToken)) {

            $this->addFlash('error',
                'Token sécurité invalide, veuillez ré-essayer.');

        }
        else {

            // Suppression de l'article en BDD
            $em =
                $doctrine->getManager();
            $em->remove($futureEvent);
            $em->flush();

            // Message flash de succès
            $this->addFlash('success',
                "L'évenement' a été supprimé avec succès !");

        }

        // Redirection vers la page qui liste les articles
        return $this->redirectToRoute('admin_panel_events_list');
    }


    #[Route('/modification-d\'un-evenement/{id}/', name: 'event_edit_', priority: 10)]
//    #[IsGranted('ROLE_ADMIN')]
    public function publicationEdit(FutureEvent     $futureEvent,
                                    Request         $request,
                                    ManagerRegistry $doctrine): Response
    {

        // Instanciation d'un nouveau formulaire basé sur $article qui contient déjà les données actuelles de l'article à modifier
        $form =
            $this->createForm(CreateEventFormType::class,
                $futureEvent);

        $form->handleRequest($request);

        // Si le formulaire est envoyé et sans erreur
        if ($form->isSubmitted() &&
            $form->isValid()) {

            // Sauvegarde des données modifiées en BDD
            $em =
                $doctrine->getManager();
            $em->flush();

            // Message flash de succès
            $this->addFlash('success',
                'Publication modifiée avec succès !');

            // Redirection vers l'article modifié
            return $this->redirectToRoute('admin_panel_events_list',
                [
                    'id' => $futureEvent->getId(),
                ]);

        }

        return $this->render('admin_panel/admin_event_edit.html.twig',
            [
                'form' => $form->createView(),
            ]);

    }


    ////////////////////////////////////////////////////////////////////
    /// Users

    #[Route('/liste-des-utilisateurs', name: 'users_list')]
    public function usersList(ManagerRegistry    $doctrine,
                              Request            $request,
                              PaginatorInterface $paginator): Response
    {

        $requestedPage =
            $request->query->getInt('page',
                1);

        if ($requestedPage <
            1) {
            throw new NotFoundHttpException();
        }

        $em =
            $doctrine->getManager();

        $query =
            $em->createQuery('SELECT a FROM App\Entity\User a ORDER BY a.id DESC');

        $users =
            $paginator->paginate(
                $query,
                $requestedPage,
                25,
            );

        return $this->render('admin_panel/admin_users_list.html.twig',
            [
                'users' => $users,
            ]);
    }

    //////////////////////////////////////////////////////////

    #[Route('/modification-d\'un-utilisateur/{id}/', name: 'user_edit_', priority: 10)]
//    #[IsGranted('ROLE_ADMIN')]
    public function userEdit(User            $user,
                             Request         $request,
                             ManagerRegistry $doctrine): Response
    {

        // Instanciation d'un nouveau formulaire basé sur $article qui contient déjà les données actuelles de l'article à modifier
        $form =
            $this->createForm(RegistrationFormType::class,
                $user);

        $form->handleRequest($request);

        // Si le formulaire est envoyé et sans erreur
        if ($form->isSubmitted() &&
            $form->isValid()) {

            // Sauvegarde des données modifiées en BDD
            $em = $doctrine->getManager();
            $em->flush();

            // Message flash de succès
            $this->addFlash('success',
                'Publication modifiée avec succès !');

            // Redirection vers l'article modifié
            return $this->redirectToRoute('admin_panel_users_list',
                [
                    'id' => $user->getId(),
                ]);

        }

        return $this->render('admin_panel/admin_user_edit.html.twig',
            [
                'form' => $form->createView(),
            ]);

    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////:
    #[Route('/creer-une-boutique', name: 'admin_shop_creation')]
//    TODO: Penser à activer le role admin sur cette page une fois les roles créés et les tests terminés
//    #[isGranted('ROLE_ADMIN')]
    public function createShop(ManagerRegistry $doctrine, Request $request,): Response
    {

        $shop = new Shop();

        $form = $this->createForm(CreateShopFormType::class, $shop);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            //  Avec l'aPI Nominatim, on récupère la latitude et la longitude de la boutique grâce à l'adresse saisie et
            // présente en bdd.
            $address = $shop->getAddress() . " " . $shop->getZip() . " " . $shop->getCity() . " " . $shop->getCountry();

            $prepAddr = str_replace(' ', '+', $address);

            $referer = "https://nominatim.openstreetmap.org/search?q='.$prepAddr.'&format=json"; // La connexion à
            // l'API nominatim requière de passer par le referer (un paramètre du header dans le navigateur)
            $opts = array(
                'http' => array(
                    'header' => array("Referer: $referer\r\n")
                )
            );
            $context = stream_context_create($opts);
            $geocode = file_get_contents($referer, false, $context);

            $output = json_decode($geocode);

            $latitude = $output[0]->lat;
            $longitude = $output[0]->lon;

            $shop->setLatitude($latitude);
            $shop->setLongitude($longitude);


            $em = $doctrine->getManager();
            $em->persist($shop);
            $em->flush();

            $this->addFlash('success', 'Boutique ajoutée avec succès');
        }

        return $this->render('admin_panel/admin_shop_creation.html.twig', [
            'form' => $form->createView()
        ]);
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    #[Route('/inscription', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {


            if ($form->isValid()) {

                // encode the plain password
                $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('main_home');
            }
        }

        return $this->render('admin_panel/admin_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    #[Route('/modifier-accueil', name: 'home_presentation')]
    public function homePresentation(ManagerRegistry $doctrine, Request $request): Response
    {
        $homePresentation = new HomePresentation();

        $form = $this->createForm(HomePresentationFormType::class, $homePresentation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $photo = $form->get('presentationImage')->getData();
            dump($homePresentation->getPresentationText());
            dump($homePresentation->getPresentationImage());

//            unlink($this->getParameter('app.home.photo.directory') . $homePresentation->getPresentationImage());
            if(
                $homePresentation->getPresentationText() != null &&
                $homePresentation->getPresentationImage() != null &&
                file_exists($this->getParameter('app.home.photo.directory') . $homePresentation->getPresentationImage() )
            ){

                dump($this->getParameter('app.home.photo.directory') . $homePresentation->getPresentationImage());
            }

            do{
                $newFileName = md5( random_bytes(100) ) . '.' . $photo->guessExtension();
            } while (file_exists($this->getParameter('app.home.photo.directory') .$newFileName));

            $homePresentation->setPresentationImage($newFileName);

            $em = $doctrine->getManager();
            $em->persist($homePresentation);
            $em->flush();

            $photo -> move(
                $this->getParameter('app.home.photo.directory'),
                $newFileName,
            );

            $this->addFlash('success', 'Présentation actualisée avec succès');
        }


            return $this->render('admin_panel/admin_home_presentation.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

}