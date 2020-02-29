<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WpPostsRepository")
 */
class WpPosts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=100)
     */
    private $postAuthor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postDateGmt;

    /**
     * @ORM\Column(type="text")
     */
    private $postContent;

    /**
     * @ORM\Column(type="text")
     */
    private $postTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $postExcerpt;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $postStatus;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $commentStatus;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $pingStatus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postPassword;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $postName;

    /**
     * @ORM\Column(type="text")
     */
    private $toPing;

    /**
     * @ORM\Column(type="text")
     */
    private $pinged;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postModified;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postModifiedGmt;

    /**
     * @ORM\Column(type="text")
     */
    private $postContentFiltered;

    /**
     * @ORM\Column(type="integer")
     */
    private $postParent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $guid;

    /**
     * @ORM\Column(type="integer")
     */
    private $menuOrder;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $postType;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $postMimeType;

    /**
     * @ORM\Column(type="integer")
     */
    private $commentCount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="article")
     */
    private $commentaires;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->wpComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostAuthor(): ?string
    {
        return $this->postAuthor;
    }

    public function setPostAuthor(string $postAuthor): self
    {
        $this->postAuthor = $postAuthor;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->postDate;
    }

    public function setPostDate(\DateTimeInterface $postDate): self
    {
        $this->postDate = $postDate;

        return $this;
    }

    public function getPostDateGmt(): ?\DateTimeInterface
    {
        return $this->postDateGmt;
    }

    public function setPostDateGmt(\DateTimeInterface $postDateGmt): self
    {
        $this->postDateGmt = $postDateGmt;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->postContent;
    }

    public function setPostContent(string $postContent): self
    {
        $this->postContent = $postContent;

        return $this;
    }

    public function getPostTitle(): ?string
    {
        return $this->postTitle;
    }

    public function setPostTitle(string $postTitle): self
    {
        $this->postTitle = $postTitle;

        return $this;
    }

    public function getPostExcerpt(): ?string
    {
        return $this->postExcerpt;
    }

    public function setPostExcerpt(string $postExcerpt): self
    {
        $this->postExcerpt = $postExcerpt;

        return $this;
    }

    public function getPostStatus(): ?string
    {
        return $this->postStatus;
    }

    public function setPostStatus(string $postStatus): self
    {
        $this->postStatus = $postStatus;

        return $this;
    }

    public function getCommentStatus(): ?string
    {
        return $this->commentStatus;
    }

    public function setCommentStatus(string $commentStatus): self
    {
        $this->commentStatus = $commentStatus;

        return $this;
    }

    public function getPingStatus(): ?string
    {
        return $this->pingStatus;
    }

    public function setPingStatus(string $pingStatus): self
    {
        $this->pingStatus = $pingStatus;

        return $this;
    }

    public function getPostPassword(): ?string
    {
        return $this->postPassword;
    }

    public function setPostPassword(string $postPassword): self
    {
        $this->postPassword = $postPassword;

        return $this;
    }

    public function getPostName(): ?string
    {
        return $this->postName;
    }

    public function setPostName(string $postName): self
    {
        $this->postName = $postName;

        return $this;
    }

    public function getToPing(): ?string
    {
        return $this->toPing;
    }

    public function setToPing(string $toPing): self
    {
        $this->toPing = $toPing;

        return $this;
    }

    public function getPinged(): ?string
    {
        return $this->pinged;
    }

    public function setPinged(string $pinged): self
    {
        $this->pinged = $pinged;

        return $this;
    }

    public function getPostModified(): ?\DateTimeInterface
    {
        return $this->postModified;
    }

    public function setPostModified(\DateTimeInterface $postModified): self
    {
        $this->postModified = $postModified;

        return $this;
    }

    public function getPostModifiedGmt(): ?\DateTimeInterface
    {
        return $this->postModifiedGmt;
    }

    public function setPostModifiedGmt(\DateTimeInterface $postModifiedGmt): self
    {
        $this->postModifiedGmt = $postModifiedGmt;

        return $this;
    }

    public function getPostContentFiltered(): ?string
    {
        return $this->postContentFiltered;
    }

    public function setPostContentFiltered(string $postContentFiltered): self
    {
        $this->postContentFiltered = $postContentFiltered;

        return $this;
    }

    public function getPostParent(): ?int
    {
        return $this->postParent;
    }

    public function setPostParent(int $postParent): self
    {
        $this->postParent = $postParent;

        return $this;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): self
    {
        $this->guid = $guid;

        return $this;
    }

    public function getMenuOrder(): ?int
    {
        return $this->menuOrder;
    }

    public function setMenuOrder(int $menuOrder): self
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    public function getPostType(): ?string
    {
        return $this->postType;
    }

    public function setPostType(string $postType): self
    {
        $this->postType = $postType;

        return $this;
    }

    public function getPostMimeType(): ?string
    {
        return $this->postMimeType;
    }

    public function setPostMimeType(string $postMimeType): self
    {
        $this->postMimeType = $postMimeType;

        return $this;
    }

    public function getCommentCount(): ?int
    {
        return $this->commentCount;
    }

    public function setCommentCount(int $commentCount): self
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WpComments[]
     */
    public function getWpComments(): Collection
    {
        return $this->wpComments;
    }
}
