<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropositionRepository")
 */
class Proposition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneProposition", mappedBy="proposition")
     */
    private $lignePropositions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Acces", mappedBy="proposition")
     */
    private $acces;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OffreEmplois", inversedBy="propositions")
     */
    private $OffreEmplois;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statu;

    public function __construct()
    {
        $this->lignePropositions = new ArrayCollection();
        $this->acces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|LigneProposition[]
     */
    public function getLignePropositions(): Collection
    {
        return $this->lignePropositions;
    }

    public function addLigneProposition(LigneProposition $ligneProposition): self
    {
        if (!$this->lignePropositions->contains($ligneProposition)) {
            $this->lignePropositions[] = $ligneProposition;
            $ligneProposition->setProposition($this);
        }

        return $this;
    }

    public function removeLigneProposition(LigneProposition $ligneProposition): self
    {
        if ($this->lignePropositions->contains($ligneProposition)) {
            $this->lignePropositions->removeElement($ligneProposition);
            // set the owning side to null (unless already changed)
            if ($ligneProposition->getProposition() === $this) {
                $ligneProposition->setProposition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Acces[]
     */
    public function getAcces(): Collection
    {
        return $this->acces;
    }

    public function addAcce(Acces $acce): self
    {
        if (!$this->acces->contains($acce)) {
            $this->acces[] = $acce;
            $acce->setProposition($this);
        }

        return $this;
    }

    public function removeAcce(Acces $acce): self
    {
        if ($this->acces->contains($acce)) {
            $this->acces->removeElement($acce);
            // set the owning side to null (unless already changed)
            if ($acce->getProposition() === $this) {
                $acce->setProposition(null);
            }
        }

        return $this;
    }

    public function getOffreEmplois(): ?OffreEmplois
    {
        return $this->OffreEmplois;
    }

    public function setOffreEmplois(?OffreEmplois $OffreEmplois): self
    {
        $this->OffreEmplois = $OffreEmplois;

        return $this;
    }

    public function getStatu(): ?bool
    {
        return $this->statu;
    }

    public function setStatu(?bool $statu): self
    {
        $this->statu = $statu;

        return $this;
    }
}
