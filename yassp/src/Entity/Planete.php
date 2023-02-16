<?php

namespace App\Entity;

use App\Repository\PlaneteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: PlaneteRepository::class)]
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

    #[Ignore]
    public string $password = "toto123";

}
