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
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="projets")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Phase::class, mappedBy="projet")
     */
    private $phases;

    /**
     * @ORM\OneToMany(targetEntity=UserProjet::class, mappedBy="projet")
     */
    private $userProjets;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    public function __construct()
    {
        $this->phases = new ArrayCollection();
        $this->userProjets = new ArrayCollection();
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


    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Phase>
     */
    public function getPhases(): Collection
    {
        return $this->phases;
    }

    public function addPhase(Phase $phase): self
    {
        if (!$this->phases->contains($phase)) {
            $this->phases[] = $phase;
            $phase->setProjet($this);
        }

        return $this;
    }

    public function removePhase(Phase $phase): self
    {
        if ($this->phases->removeElement($phase)) {
            // set the owning side to null (unless already changed)
            if ($phase->getProjet() === $this) {
                $phase->setProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserProjet>
     */
    public function getUserProjets(): Collection
    {
        return $this->userProjets;
    }

    public function addUserProjet(UserProjet $userProjet): self
    {
        if (!$this->userProjets->contains($userProjet)) {
            $this->userProjets[] = $userProjet;
            $userProjet->setProjet($this);
        }

        return $this;
    }

    public function removeUserProjet(UserProjet $userProjet): self
    {
        if ($this->userProjets->removeElement($userProjet)) {
            // set the owning side to null (unless already changed)
            if ($userProjet->getProjet() === $this) {
                $userProjet->setProjet(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->intitule;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }
}
