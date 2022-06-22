<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $ClientNom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ClientPrenom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ClientRaisonSociale;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ClientSiege;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $ClientTel;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ClientEmail;

    /**
     * @ORM\OneToMany(targetEntity=Projet::class, mappedBy="client")
     */
    private $projets;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientNom(): ?string
    {
        return $this->ClientNom;
    }

    public function setClientNom(string $ClientNom): self
    {
        $this->ClientNom = $ClientNom;

        return $this;
    }

    public function getClientPrenom(): ?string
    {
        return $this->ClientPrenom;
    }

    public function setClientPrenom(string $ClientPrenom): self
    {
        $this->ClientPrenom = $ClientPrenom;

        return $this;
    }

    public function getClientRaisonSociale(): ?string
    {
        return $this->ClientRaisonSociale;
    }

    public function setClientRaisonSociale(string $ClientRaisonSociale): self
    {
        $this->ClientRaisonSociale = $ClientRaisonSociale;

        return $this;
    }

    public function getClientSiege(): ?string
    {
        return $this->ClientSiege;
    }

    public function setClientSiege(?string $ClientSiege): self
    {
        $this->ClientSiege = $ClientSiege;

        return $this;
    }

    public function getClientTel(): ?string
    {
        return $this->ClientTel;
    }

    public function setClientTel(string $ClientTel): self
    {
        $this->ClientTel = $ClientTel;

        return $this;
    }

    public function getClientEmail(): ?string
    {
        return $this->ClientEmail;
    }

    public function setClientEmail(string $ClientEmail): self
    {
        $this->ClientEmail = $ClientEmail;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projets[] = $projet;
            $projet->setClient($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getClient() === $this) {
                $projet->setClient(null);
            }
        }

        return $this;
    }
}
