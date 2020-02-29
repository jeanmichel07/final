<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatureRepository")
 */
class Candidature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OffreEmplois", inversedBy="candidatures")
     */
    private $offreEmplois;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Candidat", inversedBy="candidatures")
     */
    private $candidat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ds;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
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

    public function getLm()
    {
        return $this->lm;
    }

    public function setLm($lm)
    {
        $this->lm = $lm;

        return $this;
    }

    public function getDs()
    {
        return $this->ds;
    }

    public function setDs($ds)
    {
        $this->ds = $ds;

        return $this;
    }
}
