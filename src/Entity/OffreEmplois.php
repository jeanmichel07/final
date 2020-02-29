<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreEmploisRepository")
 */
class OffreEmplois
{
    const CONTRAT = [
        'CDI' => 'CDI',
        'CDD' => 'CDD',
        'Stage' => 'Stage'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contrat;

    public function getContratType(): string
    {
        return self::CONTRAT[$this->contrat];
    }

    /**
     * @ORM\Column(type="text")
     */
    private $activite;

    /**
     * @ORM\Column(type="text")
     */
    private $mission;

    /**
     * @ORM\Column(type="text")
     */
    private $profil;

    /**
     * @ORM\Column(type="text")
     */
    private $reference;

    /**
     * @ORM\Column( type="datetime", nullable=true)

     */
    private $dateLimite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="offreEmplois")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Candidature", mappedBy="offreEmplois")
     */
    private $candidatures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposition", mappedBy="OffreEmplois")
     */
    private $propositions;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cooptation", mappedBy="offreEmplois")
     */
    private $cooptations;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;


    public function __construct()
    {
        $this->acces = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->propositions = new ArrayCollection();
        $this->cooptations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }


    public function getContrat(): ?string
    {
        return $this->contrat;
    }

    public function setContrat(string $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(string $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(string $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->dateLimite;
    }

    public function setDateLimite(\DateTimeInterface $dateLimite): self
    {
        $this->dateLimite = $dateLimite;

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
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setOffreEmplois($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->contains($candidature)) {
            $this->candidatures->removeElement($candidature);
            // set the owning side to null (unless already changed)
            if ($candidature->getOffreEmplois() === $this) {
                $candidature->setOffreEmplois(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proposition[]
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

    public function addProposition(Proposition $proposition): self
    {
        if (!$this->propositions->contains($proposition)) {
            $this->propositions[] = $proposition;
            $proposition->setOffreEmplois($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): self
    {
        if ($this->propositions->contains($proposition)) {
            $this->propositions->removeElement($proposition);
            // set the owning side to null (unless already changed)
            if ($proposition->getOffreEmplois() === $this) {
                $proposition->setOffreEmplois(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Cooptation[]
     */
    public function getCooptations(): Collection
    {
        return $this->cooptations;
    }

    public function addCooptation(Cooptation $cooptation): self
    {
        if (!$this->cooptations->contains($cooptation)) {
            $this->cooptations[] = $cooptation;
            $cooptation->setOffreEmplois($this);
        }

        return $this;
    }

    public function removeCooptation(Cooptation $cooptation): self
    {
        if ($this->cooptations->contains($cooptation)) {
            $this->cooptations->removeElement($cooptation);
            // set the owning side to null (unless already changed)
            if ($cooptation->getOffreEmplois() === $this) {
                $cooptation->setOffreEmplois(null);
            }
        }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

}
