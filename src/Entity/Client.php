<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $web;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secteur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Temoignage", mappedBy="client")
     */
    private $temoignages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OffreEmplois", mappedBy="client")
     */
    private $offreEmplois;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Responsable", mappedBy="client")
     */
    private $responsables;


    public function __construct()
    {
        $this->temoignages = new ArrayCollection();
        $this->offreEmplois = new ArrayCollection();
        $this->responsables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
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

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(?string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(?string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Temoignage[]
     */
    public function getTemoignages(): Collection
    {
        return $this->temoignages;
    }

    public function addTemoignage(Temoignage $temoignage): self
    {
        if (!$this->temoignages->contains($temoignage)) {
            $this->temoignages[] = $temoignage;
            $temoignage->setClient($this);
        }

        return $this;
    }

    public function removeTemoignage(Temoignage $temoignage): self
    {
        if ($this->temoignages->contains($temoignage)) {
            $this->temoignages->removeElement($temoignage);
            // set the owning side to null (unless already changed)
            if ($temoignage->getClient() === $this) {
                $temoignage->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OffreEmplois[]
     */
    public function getOffreEmplois(): Collection
    {
        return $this->offreEmplois;
    }

    public function addOffreEmplois(OffreEmplois $offreEmplois): self
    {
        if (!$this->offreEmplois->contains($offreEmplois)) {
            $this->offreEmplois[] = $offreEmplois;
            $offreEmplois->setClient($this);
        }

        return $this;
    }

    public function removeOffreEmplois(OffreEmplois $offreEmplois): self
    {
        if ($this->offreEmplois->contains($offreEmplois)) {
            $this->offreEmplois->removeElement($offreEmplois);
            // set the owning side to null (unless already changed)
            if ($offreEmplois->getClient() === $this) {
                $offreEmplois->setClient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nom;
    }

    /**
     * @return Collection|Responsable[]
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
            $responsable->setClient($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): self
    {
        if ($this->responsables->contains($responsable)) {
            $this->responsables->removeElement($responsable);
            // set the owning side to null (unless already changed)
            if ($responsable->getClient() === $this) {
                $responsable->setClient(null);
            }
        }

        return $this;
    }

}
