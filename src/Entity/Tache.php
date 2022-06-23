<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity=Employe::class, inversedBy="taches")
     */
    private $employe;

    /**
     * @ORM\ManyToOne(targetEntity=Phase::class, inversedBy="taches")
     */
    private $phase;

    /**
     * @ORM\OneToMany(targetEntity=Livrable::class, mappedBy="Tache")
     */
    private $livrables;

    public function __construct()
    {
        $this->livrables = new ArrayCollection();
    }

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

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getPhase(): ?Phase
    {
        return $this->phase;
    }

    public function setPhase(?Phase $phase): self
    {
        $this->phase = $phase;

        return $this;
    }

    /**
     * @return Collection<int, Livrable>
     */
    public function getLivrables(): Collection
    {
        return $this->livrables;
    }

    public function addLivrable(Livrable $livrable): self
    {
        if (!$this->livrables->contains($livrable)) {
            $this->livrables[] = $livrable;
            $livrable->setTache($this);
        }

        return $this;
    }

    public function removeLivrable(Livrable $livrable): self
    {
        if ($this->livrables->removeElement($livrable)) {
            // set the owning side to null (unless already changed)
            if ($livrable->getTache() === $this) {
                $livrable->setTache(null);
            }
        }

        return $this;
    }
}