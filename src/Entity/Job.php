<?php

namespace App\Entity;

use App\Repository\JobRepository;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

// Informe doctrine qu'on a besoin qu'il gérer le cycle de vie de l'entity
#[HasLifecycleCallbacks()]
#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{

    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }
}
