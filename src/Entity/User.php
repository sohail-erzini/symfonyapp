<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message= "email already exists log in instead"
 * )
 * @method string getUserIdentifier()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="6", minMessage="Password should at least be 6 chars")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password", message="Confirmation not equal to password")
     */

    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $LastName;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $Image;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Nationalite;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $Sexe;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Tel;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $Roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Tache::class, mappedBy="user")
     */
    private $taches;

    /**
     * @ORM\OneToMany(targetEntity=UserProjet::class, mappedBy="user")
     */
    private $userProjets;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEmbauche;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->userProjets = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }


    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }


    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

   

    public function getImage()
    {
        return $this->Image;
    }

    public function setImage($Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }


    public function setMatricule(?string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->Nationalite;
    }


    public function setNationalite(?string $Nationalite): self
    {
        $this->Nationalite = $Nationalite;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(string $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }


    public function setTel(?string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function getRoles():array
    {
        $roles = $this->Roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(?array $Roles): self
    {
        $this->Roles = $Roles;

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setUser($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getUser() === $this) {
                $tach->setUser(null);
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
            $userProjet->setUser($this);
        }

        return $this;
    }

    public function removeUserProjet(UserProjet $userProjet): self
    {
        if ($this->userProjets->removeElement($userProjet)) {
            // set the owning side to null (unless already changed)
            if ($userProjet->getUser() === $this) {
                $userProjet->setUser(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->username;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(?\DateTimeInterface $dateEmbauche): self
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }


}
