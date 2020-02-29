<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentairesRepository")
 */
class Commentaires
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WpPosts", inversedBy="commentaires")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Candidat", inversedBy="commentaires")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Responsable", inversedBy="commentaires")
     */
    private $authorClient;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?WpPosts
    {
        return $this->article;
    }

    public function setArticle(?WpPosts $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getAuthor(): ?Candidat
    {
        return $this->author;
    }

    public function setAuthor(?Candidat $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthorClient(): ?Responsable
    {
        return $this->authorClient;
    }

    public function setAuthorClient(?Responsable $authorClient): self
    {
        $this->authorClient = $authorClient;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

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
