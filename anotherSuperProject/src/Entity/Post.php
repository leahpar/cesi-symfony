<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $title;

    #[ORM\Column(type: 'text')]
    public $content;

    #[ORM\Column(type: 'datetime')]
    public $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

}
