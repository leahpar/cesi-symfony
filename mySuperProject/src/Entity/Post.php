<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column(type: 'string', length: 255)]
    public ?string $title = null;

    #[ORM\Column(type: 'text')]
    public ?string $content = null;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }
}
