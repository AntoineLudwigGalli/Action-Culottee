<?php

namespace App\Entity;

use App\Repository\HomePresentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomePresentationRepository::class)]
class HomePresentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $presentationText;

    #[ORM\Column(type: 'string', length: 50)]
    private $presentationImage;

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
}
