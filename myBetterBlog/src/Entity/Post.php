<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            'normalization_context' => ['groups' => ['articles_get']],
        ],
        "post" => [
            "security_post_denormalize" => "is_granted('POST', object)",
        ],
    ],
    itemOperations: [
        "get" => [
            'normalization_context' => ['groups' => ['article_get']]
        ],
        "put" => [
            //"security_post_denormalize" => "is_granted('ROLE_ADMIN') or (is_granted('ROLE_AUTEUR') and object.getAuteur() == user and previous_object.getAuteur() == user)",
            "security_post_denormalize" => "is_granted('PUT', object) and is_granted('PUT', previous_object)"
        ],
        "patch" => [
            "security_post_denormalize" => "is_granted('ROLE_ADMIN') or (is_granted('ROLE_AUTEUR') and object.getAuteur() == user and previous_object.getAuteur() == user)"
        ],
        "delete" => [
            "security" => "is_granted('ROLE_ADMIN')"
        ],
    ],
    attributes: [
        "pagination_items_per_page" => 5,
    ],
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['articles_get', 'article_get'])]
    #[Assert\NotNull]
    #[Assert\Length(min: 10, max: 50)]
    private $titre;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiSubresource]
    #[Groups(['articles_get', 'article_get'])]
    private $auteur;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['article_get'])]
    #[Assert\Length(min: 100)]
    private $contenu;

    #[ORM\Column(type: 'date')]
    #[Groups(['articles_get', 'article_get'])]
    #[Assert\GreaterThan('today')]
    private $date;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['articles_get', 'article_get'])]
    private $publie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPublie(): ?bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): self
    {
        $this->publie = $publie;

        return $this;
    }

    public function __toString(): string
    {
        return $this->titre;
    }

    #[Groups(['articles_get'])]
    public function getResume(): string
    {
        return substr($this->contenu, 0, 100) . "...";
    }

}
