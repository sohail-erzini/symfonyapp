<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TacheRepository::class)
 */
class Tache
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priorite;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dateAffectation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dateModif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriorite(): ?float
    {
        return $this->priorite;
    }

    public function setPriorite(?float $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->dateFin;
    }

    public function setDateFin(?string $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateAffectation(): ?string
    {
        return $this->dateAffectation;
    }

    public function setDateAffectation(?string $dateAffectation): self
    {
        $this->dateAffectation = $dateAffectation;

        return $this;
    }

    public function getDateModif(): ?string
    {
        return $this->dateModif;
    }

    public function setDateModif(?string $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }
}
