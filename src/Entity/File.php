<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @Vich\Uploadable()
 */
class File
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File|null
     * @Vich\UploadableField(mapping="participant_file", fileNameProperty="filename", mimeType="minetype")
     */
    private $file;

    /**
     * @return \Symfony\Component\HttpFoundation\File\File|null
     */
    public function getFile(): ?\Symfony\Component\HttpFoundation\File\File
    {
        return $this->file;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File|null $file
     * @return File
     */
    public function setFile(?\Symfony\Component\HttpFoundation\File\File $file): File
    {
        $this->file = $file;
        return $this;
    }


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $minetype;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participants", inversedBy="files")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participants;

    public function __toString()
    {
        return $this->filename ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getMinetype(): ?string
    {
        return $this->minetype;
    }

    public function setMinetype(string $minetype): self
    {
        $this->minetype = $minetype;

        return $this;
    }

    public function getParticipants(): ?Participants
    {
        return $this->participants;
    }

    public function setParticipants(?Participants $participants): self
    {
        $this->participants = $participants;

        return $this;
    }
}
