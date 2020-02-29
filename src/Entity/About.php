<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AboutRepository")
 */
class About
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\candidat", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?candidat
    {
        return $this->user;
    }

    public function setUser(?candidat $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }
}
