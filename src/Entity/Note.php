<?php

namespace App\Entity;

use App\Config\NoteColor;
use App\Repository\NoteRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[NotBlank]
    #[Length(min: 3)]
    private string $title;

    #[ORM\Column(type: 'text')]
    #[NotBlank]
    #[Length(min: 20)]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'string', length: 255, enumType: NoteColor::class, columnDefinition: NoteColor::class)]
    #[NotBlank]
    private NoteColor $color;

    #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private Folder $folder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getColor(): ?NoteColor
    {
        return $this->color;
    }

    public function setColor(NoteColor $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function setFolder(?Folder $folder): self
    {
        $this->folder = $folder;

        return $this;
    }
}
