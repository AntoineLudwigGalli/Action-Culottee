<?php

namespace App\Twig;

use App\Entity\DynamicContent;
use Doctrine\Persistence\ManagerRegistry;
use Exercise\HTMLPurifierBundle\HTMLPurifiersRegistry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use \HTMLPurifier;

class AppExtension extends AbstractExtension
{

    private $doctrine;
    private $purifier;

    public function __construct(ManagerRegistry $doctrine, HTMLPurifier $purifier){
        $this->doctrine = $doctrine;
        $this->purifier = $purifier;
    }

//    public function getFilters(): array
//    {
//        return [
//            // If your filter generates SAFE HTML, you should add a third
//            // parameter: ['is_safe' => ['html']]
//            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
//            new TwigFilter('filter_name', [$this, 'doSomething']),
//        ];
//    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('display_dynamic_content', [$this, 'displayDynamicContent'], ['is_safe' => ['html']]),
        ];
    }

    public function displayDynamicContent(string $name): string
    {

        $dynamicContentRepo = $this->doctrine->getRepository(DynamicContent::class);

        $currentDynamicContent = $dynamicContentRepo->findOneByName($name);

        return (empty($currentDynamicContent) ? '' : $this->purifier->purify($currentDynamicContent->getContent())) . '<a href="/admin/contenu-dynamique/modifier/'.
            $currentDynamicContent->getName() .'">Modifier</a>';
    }
}
