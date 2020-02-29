<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 */
class Candidat implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min="4" , minMessage="Votre nom est trop court")
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8" , minMessage="Votre mot de passe est trop court")
     * @Assert\EqualTo(propertyPath="confirmPassword", message="Les deux mot de passe doivent etre identique")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password", message="Les deux mot de passe doivent etre identique")
     */
    public $confirmPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="candidat")
     */
    private $temoignageCandidats;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Candidature", mappedBy="candidat")
     */
    private $candidatures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneProposition", mappedBy="candidat")
     */
    private $lignePropositions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserType", inversedBy="candidats")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parcours", mappedBy="candidat")
     */
    private $parcours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formation", mappedBy="candidat")
     */
    private $formations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CandidatSexe", inversedBy="candidat")
     */
    private $candidatSexe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SituationFamilier", inversedBy="candidat")
     */
    private $situation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="author")
     */
    private $commentaires;

    public function __construct()
    {
        $this->temoignageCandidats = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->lignePropositions = new ArrayCollection();
        $this->parcours = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    /**
     * @return Collection|Video[]
     */
    public function getTemoignageCandidats(): Collection
    {
        return $this->temoignageCandidats;
    }

    public function addTemoignageCandidat(Video $temoignageCandidat): self
    {
        if (!$this->temoignageCandidats->contains($temoignageCandidat)) {
            $this->temoignageCandidats[] = $temoignageCandidat;
            $temoignageCandidat->setCandidat($this);
        }

        return $this;
    }

    public function removeTemoignageCandidat(Video $temoignageCandidat): self
    {
        if ($this->temoignageCandidats->contains($temoignageCandidat)) {
            $this->temoignageCandidats->removeElement($temoignageCandidat);
            // set the owning side to null (unless already changed)
            if ($temoignageCandidat->getCandidat() === $this) {
                $temoignageCandidat->setCandidat(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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
            $candidature->setCandidat($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->contains($candidature)) {
            $this->candidatures->removeElement($candidature);
            // set the owning side to null (unless already changed)
            if ($candidature->getCandidat() === $this) {
                $candidature->setCandidat(null);
            }
        }

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
            $ligneProposition->setCandidat($this);
        }

        return $this;
    }

    public function removeLigneProposition(LigneProposition $ligneProposition): self
    {
        if ($this->lignePropositions->contains($ligneProposition)) {
            $this->lignePropositions->removeElement($ligneProposition);
            // set the owning side to null (unless already changed)
            if ($ligneProposition->getCandidat() === $this) {
                $ligneProposition->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getType(): ?UserType
    {
        return $this->type;
    }

    public function setType(?UserType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Parcours[]
     */
    public function getParcours(): Collection
    {
        return $this->parcours;
    }

    public function addParcour(Parcours $parcour): self
    {
        if (!$this->parcours->contains($parcour)) {
            $this->parcours[] = $parcour;
            $parcour->setCandidat($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): self
    {
        if ($this->parcours->contains($parcour)) {
            $this->parcours->removeElement($parcour);
            // set the owning side to null (unless already changed)
            if ($parcour->getCandidat() === $this) {
                $parcour->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCandidat($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getCandidat() === $this) {
                $formation->setCandidat(null);
            }
        }

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getCandidatSexe(): ?CandidatSexe
    {
        return $this->candidatSexe;
    }

    public function setCandidatSexe(?CandidatSexe $candidatSexe): self
    {
        $this->candidatSexe = $candidatSexe;

        return $this;
    }

    public function getSituation(): ?SituationFamilier
    {
        return $this->situation;
    }

    public function setSituation(?SituationFamilier $situation): self
    {
        $this->situation = $situation;

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nom;
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
            $commentaire->setAuthor($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuthor() === $this) {
                $commentaire->setAuthor(null);
            }
        }

        return $this;
    }
}
