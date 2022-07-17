<?php

namespace App\Entity;

use App\Repository\LivrableRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=LivrableRepository::class)
 */
class Livrable
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
     * @ORM\ManyToOne(targetEntity=Tache::class, inversedBy="livrables")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $Tache;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DocFile;

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


    public function getTache(): ?Tache
    {
        return $this->Tache;
    }

    public function setTache(?Tache $Tache): self
    {
        $this->Tache = $Tache;

        return $this;
    }

    public function getDocFile(): ?string
    {
        return $this->DocFile;
    }

    public function setDocFile(?string $DocFile): self
    {
        $this->DocFile = $DocFile;

        return $this;
    }
}
