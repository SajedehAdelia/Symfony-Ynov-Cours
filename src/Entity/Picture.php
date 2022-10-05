<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
use vich\UploaderBundle\Annotation as vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
/**
 * @vich\Uploadable()
 */
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $realName = null;

    #[ORM\Column(length: 255)]
    private ?string $realPath = null;

    #[ORM\Column(length: 255)]
    private ?string $publicPath = null;

    #[ORM\Column(length: 255)]
    private ?string $mimeType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $uploadDate = null;
 /**
     * @var File|null
     * @vich\UploadableField(maping="images", fileNameProperty="realPath")
     */

    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getRealPath(): ?string
    {
        return $this->realPath;
    }

    public function setRealPath(string $realPath): self
    {
        $this->realPath = $realPath;

        return $this;
    }

    public function getPublicPath(): ?string
    {
        return $this->publicPath;
    }

    public function setPublicPath(string $publicPath): self
    {
        $this->publicPath = $publicPath;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadDate;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile($file): ?Picture
    {
        $this->file = $file;

        return $this;
    }
    
}
