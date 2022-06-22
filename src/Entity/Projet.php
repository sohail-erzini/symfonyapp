<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
    private $intitule;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Categorie;

    /**
     * @ORM\OneToMany(targetEntity=EmployeProjetRole::class, mappedBy="projet")
     */
    private $projetEmployeRoles;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="projets")
     */
    private $client;

    public function __construct()
    {
        $this->projetEmployeRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

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

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(?float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(?string $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection<int, EmployeProjetRole>
     */
    public function getProjetEmployeRoles(): Collection
    {
        return $this->projetEmployeRoles;
    }

    public function addProjetEmployeRole(EmployeProjetRole $projetEmployeRole): self
    {
        if (!$this->projetEmployeRoles->contains($projetEmployeRole)) {
            $this->projetEmployeRoles[] = $projetEmployeRole;
            $projetEmployeRole->setProjet($this);
        }

        return $this;
    }

    public function removeProjetEmployeRole(EmployeProjetRole $projetEmployeRole): self
    {
        if ($this->projetEmployeRoles->removeElement($projetEmployeRole)) {
            // set the owning side to null (unless already changed)
            if ($projetEmployeRole->getProjet() === $this) {
                $projetEmployeRole->setProjet(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
