<?php

namespace App\Entity;

use App\Repository\PostulationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Offre; 

#[ORM\Entity(repositoryClass: PostulationRepository::class)]
class Postulation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CV = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lettreMotivation = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column]
    private ?\DateTime $datePostulation = null;

    #[ORM\ManyToOne(inversedBy: 'postulations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $candidat = null;

    #[ORM\ManyToOne(inversedBy: 'postulations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?offre $offre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCV(): ?string
    {
        return $this->CV;
    }

    public function setCV(string $CV): static
    {
        $this->CV = $CV;

        return $this;
    }

    public function getLettreMotivation(): ?string
    {
        return $this->lettreMotivation;
    }

    public function setLettreMotivation(string $lettreMotivation): static
    {
        $this->lettreMotivation = $lettreMotivation;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDatePostulation(): ?\DateTime
    {
        return $this->datePostulation;
    }

    public function setDatePostulation(\DateTime $datePostulation): static
    {
        $this->datePostulation = $datePostulation;

        return $this;
    }

    public function getCandidat(): ?User
    {
        return $this->candidat;
    }

    public function setCandidat(?User $candidat): static
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getOffre(): ?offre
    {
        return $this->offre;
    }

    public function setOffre(?offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
