<?php

namespace App\Entity;

use App\Repository\HomePresentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomePresentationRepository::class)]
class DynamicContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $mainText;

    #[ORM\Column(type: 'string', length: 50)]
    private $mainImage;

    #[ORM\Column(type: 'string', length: 150)]
    private $formTitle;

    #[ORM\Column(type: 'string', length: 70)]
    private $relatedPage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentationText(): ?string
    {
        return $this->presentationText;
    }

    public function setPresentationText(string $presentationText): self
    {
        $this->presentationText = $presentationText;

        return $this;
    }

    public function getPresentationImage(): ?string
    {
        return $this->presentationImage;
    }

    public function setPresentationImage(string $presentationImage): self
    {
        $this->presentationImage = $presentationImage;

        return $this;
    }

    public function getFormTitle(): ?string
    {
        return $this->formTitle;
    }

    public function setFormTitle(string $formTitle): self
    {
        $this->formTitle = $formTitle;

        return $this;
    }

    public function getRelatedPage(): ?string
    {
        return $this->relatedPage;
    }

    public function setRelatedPage(string $relatedPage): self
    {
        $this->relatedPage = $relatedPage;

        return $this;
    }
}
