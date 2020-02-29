<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTypeRepository")
 */
class UserType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Candidat", mappedBy="type")
     */
    private $candidats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Responsable", mappedBy="type")
     */
    private $responsables;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Coopteur", mappedBy="type")
     */
    private $coopteurs;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
        $this->responsables = new ArrayCollection();
        $this->coopteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->setType($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->contains($candidat)) {
            $this->candidats->removeElement($candidat);
            // set the owning side to null (unless already changed)
            if ($candidat->getType() === $this) {
                $candidat->setType(null);
            }
        }

        return $this;
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
            $responsable->setType($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): self
    {
        if ($this->responsables->contains($responsable)) {
            $this->responsables->removeElement($responsable);
            // set the owning side to null (unless already changed)
            if ($responsable->getType() === $this) {
                $responsable->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Coopteur[]
     */
    public function getCoopteurs(): Collection
    {
        return $this->coopteurs;
    }

    public function addCoopteur(Coopteur $coopteur): self
    {
        if (!$this->coopteurs->contains($coopteur)) {
            $this->coopteurs[] = $coopteur;
            $coopteur->setType($this);
        }

        return $this;
    }

    public function removeCoopteur(Coopteur $coopteur): self
    {
        if ($this->coopteurs->contains($coopteur)) {
            $this->coopteurs->removeElement($coopteur);
            // set the owning side to null (unless already changed)
            if ($coopteur->getType() === $this) {
                $coopteur->setType(null);
            }
        }

        return $this;
    }
}
