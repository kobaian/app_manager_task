<?php

declare(strict_types=1);

namespace App\Doctrine\Behaviours;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait Identifiable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
