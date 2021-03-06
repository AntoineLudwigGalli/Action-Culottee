<?php

namespace App\Controller;


use App\Entity\FutureEvent;
use App\Entity\DynamicContent;
use App\Entity\Partner;
use App\Entity\Shop;
use App\Entity\User;
use App\Form\CreateEventFormType;
use App\Form\CreateShopFormType;
use App\Form\DynamicContentFormType;
use App\Form\EditPartnerTypeFormType;
use App\Form\EditShopTypeFormType;
use App\Form\RegistrationFormType;
use App\Form\UpdateUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use League\Csv\Writer;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use SplTempFileObject;
use App\Form\PartnerTypeFormType;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin", name: "admin_panel_")]
#[IsGranted('ROLE_ADMIN')]
class AdminPanelController extends AbstractController
{
// Page d'index
    #[Route('', name: 'index')]
    public function indexAdmin(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
// Requêtes de toutes les entrées dans les tables des entités Shop, FutureEvents, User et Partner pour en afficher le nombre dans les boutons de l'index admin
        $em = $doctrine->getManager();


        $query = $em->createQuery('SELECT e FROM App\Entity\FutureEvent e ');


        $events = $paginator->paginate($query, 55);

        $query = $em->createQuery('SELECT u FROM App\Entity\User u');

        $users = $paginator->paginate($query, 55);

        $query = $em->createQuery('SELECT s FROM App\Entity\Shop s');

        $shops = $paginator->paginate($query, 55);

        $query = $em->createQuery('SELECT p FROM App\Entity\Partner p');

        $partners = $paginator->paginate($query, 55);


        return $this->render('admin_panel/admin_index.html.twig', [
                "events" => $events,
                "users" => $users,
                "shops" => $shops,
                "partners" => $partners
            ]
        );
    }


    /**
     *
     * Events Section
     *
     */

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
            } else {
                // récupération du manager des entités et sauvegarde en BDD de $newEvent
                $em = $doctrine->getManager();

                $em->persist($newEvent);

                $em->flush();

                // Ajout message flash
                $this->addFlash("success", "Évènement créé avec succès !");
                return $this->redirectToRoute('admin_panel_events_list');
            }
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('admin_panel/admin_event.html.twig', ['form' => $form->createView(),]);
    }

    /**
     *
     *
     */
    #[Route('/liste-des-evenements', name: 'events_list')]
    public function eventList(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        // On récupère dans l'URL la donnée GET page (si elle n'existe pas, la valeur retournée par défaut sera la page 1)
        $requestedPage = $request->query->getInt('page', 1);

        // Si le numéro de page demandé dans l'URL est inférieur à 1, erreur 404
        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }
        // Récupération du manager des entités
        $em = $doctrine->getManager();

        // Création d'une requête qui servira au paginator pour récupérer les events de la page courante
        $query = $em->createQuery('SELECT e FROM App\Entity\FutureEvent e ORDER BY e.eventDate ASC');

        //On stocke dans $events les 10 events de la page demandée dans l'URL
        $events = $paginator->paginate(
            $query, // Requête de selection des events en BDD
            $requestedPage, // Numéro de la page dont on veut les events
            55); // Nombre d'events par page

        return $this->render('admin_panel/admin_events_list.html.twig', [
            'events' => $events,]); // On envoie les events récupérés à la vue
    }


    #[Route('/suppression-d\'un-evenement/{id}/', name: 'event_delete_', priority: 10)]
    public function eventDelete(FutureEvent $futureEvent, Request $request, ManagerRegistry $doctrine): Response
    {

//        Token
        $csrfToken = $request->query->get('csrf_token', '');

        if (!$this->isCsrfTokenValid('event_delete_' . $futureEvent->getId(), $csrfToken)) {

            $this->addFlash('error', 'Token de sécurité invalide, veuillez ré-essayer.');

        } else {
            // Suppression de l'event en BDD
            $em = $doctrine->getManager();
            $em->remove($futureEvent);
            $em->flush();

            // Message flash de succès
            $this->addFlash('success', "L'évènement a été supprimé avec succès !");
        }
        // Redirection vers la page qui liste les events
        return $this->redirectToRoute('admin_panel_events_list');
    }

    /**
     *
     *
     */
    #[Route('/modification-d\'un-evenement/{id}/', name: 'event_edit_', priority: 10)]
    public function publicationEdit(FutureEvent $futureEvent, Request $request, ManagerRegistry $doctrine): Response
    {


        $form = $this->createForm(CreateEventFormType::class, $futureEvent);

        //instanciation d\'un formulaire
        $form->handleRequest($request);

        //Verif du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            // Sauvegarde des données modifiées en BDD
            $em = $doctrine->getManager();
            $em->flush();

            // Message flash de succès
            $this->addFlash('success', 'Publication modifiée avec succès !');

            // Redirection vers la liste des évènements contenant maintenant l'évènement modifié
            return $this->redirectToRoute('admin_panel_events_list', ['id' => $futureEvent->getId(),]);

        }

        return $this->render('admin_panel/admin_event_edit.html.twig', ['form' => $form->createView(),]);

    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     *
     * Users Section
     *
     */

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

        return $this->render('admin_panel/admin_register.html.twig', ['registrationForm' => $form->createView(),]);
    }

    /**
     *
     *
     */

    #[Route('/liste-des-utilisateurs', name: 'users_list')]
    public function usersList(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $requestedPage = $request->query->getInt('page', 1);

        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $em = $doctrine->getManager();


        $query = $em->createQuery('SELECT u FROM App\Entity\User u ORDER BY u.id DESC');


        $users = $paginator->paginate($query, $requestedPage, 55);

        return $this->render('admin_panel/admin_users_list.html.twig', ['users' => $users,]);
    }

    /**
     *
     *
     */

    #[Route('/modification-d\'un-utilisateur/{id}/', name: 'user_edit_', priority: 10)]
    public function userEdit(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(UpdateUserFormType::class, $user);

        $form->handleRequest($request);

        // Si le formulaire est envoyé et sans erreurs
        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getRoles() != ["ROLE_ADMIN"] &&
//                Sans envoi réel de mail, on ne peut pas vérifier cette condition
//                $user->isVerified() &&
                $user->isMembershipPaid() &&
                $user->isAssociationMember()) {
                $user->setRoles(["ROLE_MEMBER"]);

            } else {

                $user->setRoles(["ROLE_USER"]);

            }

            // Sauvegarde des données modifiées en BDD
            $em = $doctrine->getManager();
            $em->flush();

            // Message flash de succès
            $this->addFlash('success', 'Utilisateur modifié avec succès !');

            // Redirection vers la liste
            return $this->redirectToRoute('admin_panel_users_list', ['id' => $user->getId(),]);

        }

        return $this->render('admin_panel/admin_user_edit.html.twig', ['form' => $form->createView(),]);

    }

    /**
     *
     *
     */
    #[Route('/suppression-d\'un-utilisateur/{id}/', name: 'user_delete_', priority: 10)]
    public function userDelete(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        $csrfToken = $request->query->get('csrf_token', '');

        if (!$this->isCsrfTokenValid('user_delete_' . $user->getId(), $csrfToken)) {

            $this->addFlash('error', 'Token sécurité invalide, veuillez ré-essayer.');

        } else {
            // Suppression de l'utilisateur en BDD
            $em = $doctrine->getManager();
            $em->remove($user);
            $em->flush();

            // Message flash de succès
            $this->addFlash('success', "L'utilisateur a été supprimé avec succès !");
        }
        // Redirection vers la page qui liste les utilisateurs
        return $this->redirectToRoute('admin_panel_users_list');
    }

    /**
     *
     *
     */

    #[Route('/rechercher-un-utilisateur/', name: 'users_search')]
    public function searchUser(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $requestedPage = $request->query->getInt('page', 1);

        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $search = $request->query->get('search', '');

        $em = $doctrine->getManager();

        $query =
            $em->createQuery('SELECT u FROM App\Entity\User u WHERE u.firstname LIKE :search OR u.lastname LIKE :search OR u.email LIKE :search OR u.phoneNumber LIKE :search OR u.memberIdNumber LIKE :search')
                ->setParameters(['search' => '%' . $search . '%']);

        $users = $paginator->paginate($query,
            $requestedPage,
            55
        );

        return $this->render('admin_panel/admin_users_search.html.twig', ['users' => $users,]);
    }


    /*    /////////////////////////////////////////////////////////////////////*/

    /// Export CSV des Users
    #[Route('/liste-des-utilisateurs/export', name: 'users_list_export')]
    public function usersListExport(ManagerRegistry $doctrine): Response
    {

// Création des en-têtes des colonnes du fichier de tableur
        $header = ['#', 'Email', 'Type de compte', 'Prénom', 'Nom', 'Numéro d\'adhérent', 'Téléphone', 'Inscription Newsletter', 'Cotisation payée', 'Compte vérifié'];

        // On va chercher tous les utilisateurs présents en bdd
        $userRepo = $doctrine->getRepository(User::class);

        $users = $userRepo->findAll();

        // Pour chaque utilisateur, on affiche ses données dans une ligne. On en profite pour rendre plus facilement lisible les données
        foreach ($users as $user) {
            $arrayUsers[] = [$user->getId(), $user->getEmail(),
                in_array('ROLE_ADMIN', $user->getRoles()) ? 'Administrateur' : (in_array('ROLE_MEMBER', $user->getRoles()) ? 'Membre' : 'Utilisateur'), $user->getFirstname(),
                $user->getLastname(), $user->getMemberIdNumber(), $user->getPhoneNumber(), $user->isNewsletterOption() ? 'Oui' : 'Non', $user->isMembershipPaid() ? 'Oui' : 'Non',
                $user->isAssociationMember() ? 'Oui' : 'Non',];
        }

        $writer = Writer::createFromFileObject(new SplTempFileObject()); //the CSV file will be created using a temporary File
        $writer->setDelimiter("\t"); //the delimiter will be the tab character
        $writer->setNewline("\r\n"); //use windows line endings for compatibility with some csv libraries
        $writer->setOutputBOM(Writer::BOM_UTF8); //adding the BOM sequence on output
        $writer->insertOne($header);
        $writer->insertAll($arrayUsers ?? []);


        // Provide a name for your file with extension
        $filename = 'users.csv';

        // Return a response with a specific content
        $response = new Response($writer);

        // Create the disposition of the file
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);

        // Set the content disposition
        $response->headers->set('Content-Disposition', $disposition);

        // Dispatch request
        return $response;

    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     *
     * Shops Section
     *
     */

    #[Route('/creer-une-boutique', name: 'shop_creation')]
    public function createShop(ManagerRegistry $doctrine, Request $request): Response
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
            // l'API nominatim requière de passer par le referer (un paramètre du header dans le navigateur.)
            $opts = array('http' => array('header' => array("Referer: $referer\r\n")));
            $context = stream_context_create($opts);
            $geocode = file_get_contents($referer, false, $context);

            $output = json_decode($geocode);

            if (empty($output)) {
                $this->addFlash('error', "L'adresse n'existe pas");
            } else {

                $latitude = $output[0]->lat;
                $longitude = $output[0]->lon;

                $shop->setLatitude($latitude);
                $shop->setLongitude($longitude);


                $em = $doctrine->getManager();
                $em->persist($shop);
                $em->flush();

                $this->addFlash('success', 'Boutique ajoutée avec succès');
                return $this->redirectToRoute('admin_panel_shops_list');
            }
        }

        return $this->render('admin_panel/admin_shop_creation.html.twig', ['form' => $form->createView()]);
    }

    /**
     *
     *
     */
    #[Route('/liste-des-boutiques', name: 'shops_list')]
    public function shopsList(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $requestedPage = $request->query->getInt('page', 1);

        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $em = $doctrine->getManager();

        $query = $em->createQuery('SELECT s FROM App\Entity\Shop s ORDER BY s.id DESC');

        $shops = $paginator->paginate($query, $requestedPage, 55);

        return $this->render('admin_panel/admin_shops_list.html.twig', ['shops' => $shops,]);
    }

    /**
     *
     *
     */
    #[Route('/modifier-une-boutique/{id}/', name: 'shop_edit_', priority: 10)]
    public function editShop(Request $request, Shop $shop, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(EditShopTypeFormType::class, $shop);

        $form->handleRequest($request);


        // Si le formulaire est envoyé et sans erreurs
        if ($form->isSubmitted() && $form->isValid()) {
            //  Avec l'aPI Nominatim, on récupère la latitude et la longitude de la boutique grâce à l'adresse saisie et
            // présente en bdd.
            $address = $shop->getAddress() . " " . $shop->getZip() . " " . $shop->getCity() . " " . $shop->getCountry();

            $prepAddr = str_replace(' ', '+', $address);

            $referer = "https://nominatim.openstreetmap.org/search?q='.$prepAddr.'&format=json"; // La connexion à
            // l'API nominatim requière de passer par le referer (un paramètre du header dans le navigateur.)
            $opts = array('http' => array('header' => array("Referer: $referer\r\n")));
            $context = stream_context_create($opts);
            $geocode = file_get_contents($referer, false, $context);

            $output = json_decode($geocode);

            if (empty($output)) {

                $this->addFlash('error', "L'adresse n'existe pas");

            } else {

                $latitude = $output[0]->lat;
                $longitude = $output[0]->lon;

                $shop->setLatitude($latitude);
                $shop->setLongitude($longitude);


                $em = $doctrine->getManager();
                $em->flush();

                $this->addFlash('success', 'Boutique modifiée avec succès');
                return $this->redirectToRoute('admin_panel_shops_list');
            }
        }

        return $this->render('admin_panel/admin_shop_edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     *
     *
     */
    #[Route('/suppression-d\'une-boutique/{id}/', name: 'shop_delete_', priority: 10)]
    public function shopDelete(Shop $shop, Request $request, ManagerRegistry $doctrine): Response
    {

        $csrfToken = $request->query->get('csrf_token', '');

        if (!$this->isCsrfTokenValid('shop_delete_' . $shop->getId(), $csrfToken)) {

            $this->addFlash('error', 'Token sécurité invalide, veuillez ré-essayer.');

        } else {
            // Suppression de la boutique en BDD
            $em = $doctrine->getManager();
            $em->remove($shop);
            $em->flush();

            // Message flash de succès
            $this->addFlash('success', "La boutique a été supprimée avec succès !");
        }
        // Redirection vers la page qui liste les boutiques
        return $this->redirectToRoute('admin_panel_shops_list');
    }

    /**
     *
     *
     */
    #[Route('/rechercher-une-boutique/', name: 'shops_search')]
    public function searchShop(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $requestedPage = $request->query->getInt('page', 1);

        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $search = $request->query->get('search', '');

        $em = $doctrine->getManager();

        $query = $em
            ->createQuery('SELECT s FROM App\Entity\Shop s WHERE s.zip LIKE :search OR s.city LIKE :search OR s.address LIKE :search OR s.phoneNumber LIKE :search OR s.country LIKE :search OR s.name LIKE :search ')
            ->setParameters(['search' => '%' . $search . '%']);

        $shops = $paginator->paginate($query, $requestedPage, 55);

        return $this->render('admin_panel/admin_shops_search.html.twig', ['shops' => $shops,]);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     *
     * Partner Section
     *
     */
    #[Route('/creer-un-partenaire', name: 'partner_creation')]
    public function partner(PartnerRepository $partnerRepository, Request $request): Response
    {
        $partner = new Partner();

        $form = $this->createForm(PartnerTypeFormType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form->get('logo')->getData();

            $ext = $file->guessExtension();

            $extArray = ['jpg', 'png', 'jpeg'];

            if (!in_array($ext, $extArray)) {

                $form->get('logo')->addError(new FormError('L\'extension du fichier n\'est pas bonne'));

            } else {

                $dir = $this->getParameter('kernel.project_dir') . '/public/images/images-partners/';

                $filename = uniqid() . '.' . $ext;

                $file->move($dir, $filename);

                $partner->setLogo($filename);


                $partnerRepository->add($partner, true);

                $this->addFlash('success', 'Partenaire ajouté avec succès');
                return $this->redirectToRoute("admin_panel_partners_list");

            }

        }


        return $this->render('admin_panel/admin_partner_creation.html.twig', ['form' => $form->createView()]);

    }

    /**
     *
     * Liste des partenaires
     *
     */
    #[Route('/liste-des-partenaires', name: 'partners_list')]
    public function partnersList(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $requestedPage = $request->query->getInt('page', 1);

        if ($requestedPage < 1) {
            throw new NotFoundHttpException();
        }

        $em = $doctrine->getManager();

        $query = $em->createQuery('SELECT p FROM App\Entity\Partner p ORDER BY p.id DESC');

        $partners = $paginator->paginate($query, $requestedPage, 55);

        return $this->render('admin_panel/admin_partners_list.html.twig', ['partners' => $partners,]);
    }

    /**
     *
     * Méthode de modification du partenaire
     *
     */
    #[Route('/modifier-un-partenaire/{id}/', name: 'partner_edit_', priority: 10)]
    public function editPartner(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {

        $filename = $partner->getLogo();

        $form = $this->createForm(EditPartnerTypeFormType::class, $partner);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('logo')->getData();

            $ext = $file->guessExtension();

            $extArray = ['jpg', 'png', 'jpeg'];

            if (!in_array($ext, $extArray)) {

                $form->get('logo')->addError(new FormError('L\'extension du fichier n\'est pas bonne'));

            } else {

                $dir = $this->getParameter('kernel.project_dir') . '/public/images/images-partners/';

                $file->move($dir, $filename);

                $partner->setLogo($filename);

                $partnerRepository->add($partner, true);

                $this->addFlash('success', 'Partenaire modifié avec succès');
                return $this->redirectToRoute("admin_panel_partners_list");
            }

        }

        return $this->render('admin_panel/admin_partner_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * Supprimer un partenaire
     *
     */
    #[Route('/suppression-d\'un-partenaire/{id}/', name: 'partner_delete_', priority: 10)]
    public function partnerDelete(Partner $partner, Request $request, ManagerRegistry $doctrine): Response
    {
        $csrfToken = $request->query->get('csrf_token', '');

        if (!$this->isCsrfTokenValid('partner_delete_' . $partner->getId(), $csrfToken)) {

            $this->addFlash('error', 'Token de sécurité invalide, veuillez ré-essayer.');

        } else {
            // Suppression du partenaire en BDD
            $em = $doctrine->getManager();
            $em->remove($partner);
            $em->flush();

            // Message flash de succès
            $this->addFlash('success', "Le partenaire a été supprimé avec succès !");
        }
        // Redirection vers la page qui liste les partenaires
        return $this->redirectToRoute('admin_panel_partners_list');
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     *
     * Dynamic Content Section
     *
     */

    #[Route('/contenu-dynamique/modifier/{name}/', name: 'dynamic_content_edit', requirements: ["name" => "[a-z0-9_-]{2,50}"])]
    public function dynamicContentEdit($name, ManagerRegistry $doctrine, Request $request): Response
    {

        //On va chercher par nom (qui sert de clé) le dynamic content correspondant
        $dynamicContentRepo = $doctrine->getRepository(DynamicContent::class);

        $currentDynamicContent = $dynamicContentRepo->findOneByName($name);

        $em = $doctrine->getManager();

        // Si le contenu est vide, on en crée un avec le nom passé dans la fonction twig
        if (empty($currentDynamicContent)) {
            $currentDynamicContent = new DynamicContent();
            $currentDynamicContent->setName($name);
            $em->persist($currentDynamicContent);
        }

        // Sinon, on modifie le contenu existant par le nouveau contenu
        $form = $this->createForm(DynamicContentFormType::class, $currentDynamicContent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $this->addFlash('success', 'Le contenu a bien été modifié !');

            return $this->redirectToRoute('main_home');

        }

        return $this->render('admin_panel/admin_dynamic_content.html.twig', ['form' => $form->createView(),]);
    }

}
