<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CooptationRepository")
 */
class Cooptation
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
     * @ORM\Column(type="string", length=255)
     */
    private $cv;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coopteur", inversedBy="cooptations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coopteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OffreEmplois", inversedBy="cooptations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offreEmplois;

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

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }



    public function getCoopteur(): ?Coopteur
    {
        return $this->coopteur;
    }

    public function setCoopteur(?Coopteur $coopteur): self
    {
        $this->coopteur = $coopteur;

        return $this;
    }

    public function getOffreEmplois(): ?OffreEmplois
    {
        return $this->offreEmplois;
    }

    public function setOffreEmplois(?OffreEmplois $offreEmplois): self
    {
        $this->offreEmplois = $offreEmplois;

        return $this;
    }
}
