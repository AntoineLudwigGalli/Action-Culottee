<?php

namespace App\Twig;

use App\Entity\DynamicContent;
use Doctrine\Persistence\ManagerRegistry;
use Exercise\HTMLPurifierBundle\HTMLPurifiersRegistry;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use \HTMLPurifier;

class AppExtension extends AbstractExtension
{
// Import des services nécessaires aux dynamic_contents
    private $doctrine;
    private $purifier;
    private $urlGenerator;
    private $authenticateUser;

    public function __construct(ManagerRegistry $doctrine, HTMLPurifier $purifier, UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $authenticateUser)
    {
        $this->doctrine = $doctrine;
        $this->purifier = $purifier;
        $this->urlGenerator = $urlGenerator;
        $this->authenticateUser = $authenticateUser;
    }

    public function getFunctions(): array
    {
        // Création de la fonction twig pour créer les dynamic_contents
        return [
            new TwigFunction('display_dynamic_content', [$this, 'displayDynamicContent'], ['is_safe' => ['html']
                ]),
        ];
    }

    public function displayDynamicContent(string $name): string
    {
// On va chercher par nom le dynamic content que l'on souhaite
        $dynamicContentRepo = $this->doctrine->getRepository(DynamicContent::class);

        $currentDynamicContent = $dynamicContentRepo->findOneByName($name);

        if($this->authenticateUser->isGranted('ROLE_ADMIN')){
// Si l'utilisateur est admin, on lui crée un bouton modifier avec une url spécifique au nom du dynamic content.
            return (empty($currentDynamicContent) ? '' : $this->purifier->purify($currentDynamicContent->getContent())) . ('<a href="' . $this->urlGenerator->generate('admin_panel_dynamic_content_edit', ['name' => $name]) . '">Modifier</a>');

        } else {
            //Sinon, on affiche le contenu dynamique
            return (empty($currentDynamicContent) ? '' : $this->purifier->purify($currentDynamicContent->getContent()));
        }
    }
}
