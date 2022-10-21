<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $id = 0;

    #[ORM\Column(type: 'string', length: 255)]
    public ?string $title = null;

    #[ORM\Column(type: 'text')]
    public ?string $content = null;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $date;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
