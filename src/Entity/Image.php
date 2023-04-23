<?php

declare(strict_types=1);

namespace App\Entity;

use App\Doctrine\Behaviours\Identifiable;
use App\Doctrine\Behaviours\Timestampable;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\Table(name: 'image')]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE')]
#[ORM\HasLifecycleCallbacks]
class Image
{
    use Identifiable;
    use Timestampable;

    #[ORM\Column(type: Types::STRING, length: 255, options: ['default' => ''])]
    protected string $name = '';

    #[ORM\Column(type: Types::STRING, length: 255, options: ['default' => ''])]
    protected string $originalPath = '';

    #[ORM\Column(type: Types::STRING, length: 255, options: ['default' => ''])]
    protected string $convertedPath = '';

    #[ORM\Column(type: Types::STRING, length: 12, options: ['default' => ''])]
    protected string $originalExtension = '';

    #[ORM\Column(type: Types::STRING, length: 12, options: ['default' => ''])]
    protected string $targetExtension = '';

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    protected int $originalSize = 0;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    protected int $convertedSize = 0;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $originalImageWidth = 0;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $originalImageHeight = 0;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $targetImageWidth = 0;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $targetImageHeight = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOriginalPath(): string
    {
        return $this->originalPath;
    }

    public function setOriginalPath(string $originalPath): self
    {
        $this->originalPath = $originalPath;

        return $this;
    }

    public function getConvertedPath(): string
    {
        return $this->convertedPath;
    }

    public function setConvertedPath(string $convertedPath): self
    {
        $this->convertedPath = $convertedPath;

        return $this;
    }

    #[ORM\PrePersist]
    public function preUpload()
    {
        if (null !== $this->getOriginalExtension() && empty($this->originalPath)) {
            $filename   = sha1($this->name . time());
            $this->originalPath = sprintf('%s.%s', $filename, $this->getOriginalExtension());
        }

        if (null !== $this->getTargetExtension() && empty($this->convertedPath)) {
            $filename   = sha1($this->name . time());
            $this->convertedPath = sprintf('%s.%s', $filename, $this->getTargetExtension());
        }
    }

    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    public function setOriginalSize(int $originalSize): self
    {
        $this->originalSize = $originalSize;

        return $this;
    }

    public function getConvertedSize(): int
    {
        return $this->convertedSize;
    }

    public function setConvertedSize(int $convertedSize): self
    {
        $this->convertedSize = $convertedSize;

        return $this;
    }

    public function getOriginalExtension(): string
    {
        return $this->originalExtension;
    }

    public function setOriginalExtension(string $originalExtension): self
    {
        $this->originalExtension = $originalExtension;

        return $this;
    }

    public function getTargetExtension(): string
    {
        return $this->targetExtension;
    }

    public function setTargetExtension(string $targetExtension): self
    {
        $this->targetExtension = $targetExtension;

        return $this;
    }

    public function getOriginalImageWidth(): int
    {
        return $this->originalImageWidth;
    }

    public function setOriginalImageWidth(int $originalImageWidth): self
    {
        $this->originalImageWidth = $originalImageWidth;

        return $this;
    }

    public function getOriginalImageHeight(): int
    {
        return $this->originalImageHeight;
    }

    public function setOriginalImageHeight(int $originalImageHeight): self
    {
        $this->originalImageHeight = $originalImageHeight;

        return $this;
    }

    public function getTargetImageWidth(): int
    {
        return $this->targetImageWidth;
    }

    public function setTargetImageWidth(int $targetImageWidth): self
    {
        $this->targetImageWidth = $targetImageWidth;

        return $this;
    }

    public function getTargetImageHeight(): int
    {
        return $this->targetImageHeight;
    }

    public function setTargetImageHeight(int $targetImageHeight): self
    {
        $this->targetImageHeight = $targetImageHeight;

        return $this;
    }
}
