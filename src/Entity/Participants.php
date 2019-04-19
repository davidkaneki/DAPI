<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantsRepository")
 */
class Participants
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $Nom;



    /**
     * @ORM\Column(type="string", length=60)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Situation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Piece_jointe;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Session", inversedBy="participants")
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="participants", cascade="persist")
     */
    private $files;

    public function __construct()
    {
        $this->titre = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function  __toString()
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->Situation;
    }

    public function setSituation(string $Situation): self
    {
        $this->Situation = $Situation;

        return $this;
    }

    public function getPieceJointe(): ?string
    {
        return $this->Piece_jointe;
    }

    public function setPieceJointe(?string $Piece_jointe): self
    {
        $this->Piece_jointe = $Piece_jointe;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getTitre(): Collection
    {
        return $this->titre;
    }

    public function addTitre(Session $titre): self
    {
        if (!$this->titre->contains($titre)) {
            $this->titre[] = $titre;
        }

        return $this;
    }

    public function removeTitre(Session $titre): self
    {
        if ($this->titre->contains($titre)) {
            $this->titre->removeElement($titre);
        }

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setParticipants($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getParticipants() === $this) {
                $file->setParticipants(null);
            }
        }

        return $this;
    }
}
