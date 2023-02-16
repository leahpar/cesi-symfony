<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlaneteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaneteRepository::class)]
#[ApiResource]
class Planete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $nom = null;

    #[ORM\Column(nullable: true)]
    public ?int $taille = null;

    #[ORM\Column(nullable: true)]
    public ?float $distance = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $name = null;

    public function getId()
    {
        return $this->id;
    }
}
