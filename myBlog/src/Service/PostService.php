<?php

namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getRandomPost(): Post
    {
        $posts = $this->em->getRepository(Post::class)->findAll();
        $post = $posts[rand(0, count($posts)-1)];
        return $post;
    }
}
