<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\CreateShopByUserFormType;
use App\Form\EditEmailFormType;
use App\Form\EditLastnameFirstnameFormType;
use App\Form\EditNewsletterTypeFormType;
use App\Form\EditPasswordTypeFormType;
use App\Form\EditPhoneNumberTypeFormType;
use App\Form\EditShopTypeFormType;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\ChangePassword;



#[Route("/user", name: "user_panel_")]
class UserPanelController extends AbstractController
{
    #[Route('/creer-une-boutique', name: 'shop_creation')]
    #[isGranted('ROLE_MEMBER')]
    public function createShop(ShopRepository $shopRepository, Request $request ): Response
    {

        $shop = new Shop();

        $form = $this->createForm(CreateShopByUserFormType::class, $shop);

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

            if(empty($output)){
                $this->addFlash('error', "L'adresse n'existe pas");
            } else {
                $latitude = $output[0]->lat;
                $longitude = $output[0]->lon;

                $shop->setLatitude($latitude);
                $shop->setLongitude($longitude);

                $shopRepository->add($shop, true);

                $this->addFlash('success', 'Boutique ajoutée avec succès');
                return $this->redirectToRoute("user_panel_manage_shop");
            }
        }

        return $this->render('user_panel/shop_creation.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     *
     * Page pour gérer la boutique de l'utilisateur
     *
     */
    #[Route('/modifier-votre-boutique', name: 'manage_shop')]
    #[isGranted('ROLE_MEMBER')]
    public function manageShop(ShopRepository $shopRepository) : Response
    {
        $user = $this->getUser();

        return $this->render('user_panel/manage_shop.html.twig');
    }


    /**
     *
     * Page de modification de boutique
     *
     */
    #[Route('/modifier-votre-boutique/modifier-boutique/{id}', name: 'edit_shop', priority: 10)]
    #[isGranted('ROLE_MEMBER')]
    public function editShop(Request $request,Shop $shop, ShopRepository $shopRepository) : Response
    {

        $form = $this->createForm(EditShopTypeFormType::class, $shop);
        $form->handleRequest( $request );

            if ( $form->isSubmitted() && $form->isValid() ) {
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

                }
                else {
                    $latitude = $output[0]->lat;
                    $longitude = $output[0]->lon;

                    $shop->setLatitude($latitude);
                    $shop->setLongitude($longitude);

                    $shopRepository->add($form->getData(), true);

                    $this->addFlash('success', 'La boutique à été modifiée avec succès !');

                    return $this->redirectToRoute('user_panel_manage_shop');
                }
            }
            return $this->render('user_panel/edit_shop.html.twig', ['form' => $form->createView()]);
        }



    /**
     *
     * Page de suppression de boutique
     *
     */
    #[Route('/modifier-votre-boutique/supprimer-boutique/{id}/', name: 'delete_shop', priority: 10)]
    #[isGranted('ROLE_MEMBER')]
    public function deleteShop(Shop $shop, ShopRepository $shopRepository,Request $request) : Response
    {
        $csrfToken = $request->query->get('csrf_token', '');

        if (!$this->isCsrfTokenValid('delete_shop' . $shop->getId(), $csrfToken)) {

            $this->addFlash('error', 'Token sécurité invalide, veuillez ré-essayer.');

        } else {
            $shopRepository->remove($shop, true);
            $this->addFlash('success', 'La boutique à été supprimée avec succès !');
        }


        return $this->redirectToRoute('user_panel_manage_shop');
    }


    /**
     *
     * Page de profil
     *
     */
    #[Route('/profil', name: 'profil')]
    #[isGranted('ROLE_USER')]
    public function userProfil(Request $request, UserRepository $userRepository) : Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditNewsletterTypeFormType::class, $user);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {

            $userRepository->add($user, true);

            $this->addFlash('success', 'Newsletter modifier avec succes');

            return $this->redirectToRoute('user_panel_profil');

        }

        return $this->render('user_panel/profil.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * Page de modification du prénom et nom
     *
     */
    #[Route('/profil/modifier-nom-et-prenom', name: 'edit_lastname_firstname')]
    #[isGranted('ROLE_USER')]
    public function userEditFirstnameLastname(Request $request, UserRepository $userRepository) : Response
    {

        $user = $this->getUser();

        $form = $this->createForm(EditLastnameFirstnameFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Ajout des nouveau nom et prénom sur l'utilisateur de la session actuel
            $user->setLastname( $form->get('lastname')->getData() );
            $user->setFirstname( $form->get('firstname')->getData() );

            $userRepository->add($user, true);

            $this->addFlash('success', 'Modification du Nom/Prénom avec success.');

            return $this->redirectToRoute('user_panel_profil');

        }

        return $this->render('user_panel/profil_edit_lastname_firstname.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     *
     * Page de modification de l'email
     *
     */
    #[Route('/profil/modifier-email', name: 'edit_email')]
    #[isGranted('ROLE_USER')]
    public function userEditEmail(EmailVerifier $emailVerifier,Request $request, UserRepository $userRepository) : Response
    {

        $user = clone $this->getUser();

        $form = $this->createForm(EditEmailFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ( $user->getEmail() == $this->getUser()->getEmail() ) {

                return $this->redirectToRoute('user_panel_edit_email');

            } else {

                $this->getUser()->setEmail( $form->get('email')->getData() );

                $userRepository->add($this->getUser(), true);

                // Envoie du mail de vérification
                $emailVerifier->sendEmailConfirmation('user_panel_edit_email', $this->getUser(), (new TemplatedEmail())
                    // TODO Mettre la vraie adresse mail
                    ->from(new \Symfony\Component\Mime\Address('a@gmail.com', 'Action Culottée'))->to($this->getUser()->getEmail())->subject('Merci de confirmer votre adresse email')
                    ->htmlTemplate('registration/confirmation_email.html.twig'));

                $this->addFlash('success', 'Modification de l\'adress email avec success. Une vérification a été envoyer dans votre boite mail');

                return $this->redirectToRoute('user_panel_profil');

            }



        }

        return $this->render('user_panel/profil_edit_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     *
     * Page de modification du mot de pass
     *
     */
    #[Route('/profil/modifier-mot-de-passe', name: 'edit_password')]
    #[isGranted('ROLE_USER')]
    public function userEditPassword(UserPasswordHasherInterface $userPasswordHasher, Request $request, UserRepository $userRepository) : Response
    {

        // Utilisateur actuellement connecter
        $user = $this->getUser();


        // Class qui permet de crée le formulaire pour après faire la comparaison avec l'utilisateur
        $changePassword = new ChangePassword();

        $form = $this->createForm(EditPasswordTypeFormType::class, $changePassword);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Si l'ancien mot de passe est bon
            if ( $userPasswordHasher->isPasswordValid( $user, $form->get('oldPassword')->getData() ) ) {

                // Si le nouveau mot de passe est identique au mot de passe actuel, on retourne
                if (
                    $form->get('newPassword')->getData() == $user->getPassword()
                ) {
                    return $this->redirectToRoute('user_panel_edit_password');
                }

                // On met le nouveau mot de passe à l'utilisateur
                $user->setPassword( $userPasswordHasher->hashPassword( $user, $form->get('newPassword')->getData() ) );

                $userRepository->add($user, true);

                $this->addFlash('success', 'Modification du mot de pass avec success');

                return $this->redirectToRoute('user_panel_profil');

            } else {

                // Sinon on crée une erreur
                $form->get('oldPassword')->addError(new FormError('Mot de pass actuel incorect'));

            }

        }

        return $this->render('user_panel/profil_edit_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     *
     * Page de modification du téléphone
     *
     */
    #[Route('/profil/modifier-telephone', name: 'edit_phone')]
    #[isGranted('ROLE_USER')]
    public function userEditPhone(Request $request, UserRepository $userRepository) : Response
    {

        $user = $this->getUser();

        $form = $this->createForm(EditPhoneNumberTypeFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->add( $user, true );

            $this->addFlash('success', 'Modification du numéro de téléphone avec succes');

            return $this->redirectToRoute('user_panel_profil');
        }

        return $this->render('user_panel/profil_edit_phone.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
