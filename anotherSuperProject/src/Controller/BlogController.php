<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/blog")]
class BlogController extends AbstractController
{

    #[Route("/add", name: 'blog_add')]
    public function add(EntityManagerInterface $em)
    {
        $em->beginTransaction();

        $post = new Post();
        $post->title = "Mon 3e post !";
        $post->content = "Lorem ipsum...";

        $em->persist($post);
        $em->flush();

        $response = $this->redirectToRoute('blog_list');
        return $response;
    }

    #[Route('/', name: 'blog_list')]
    public function list(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Post::class)->findAll();
        return $this->render("blog/posts.html.twig", [
            'posts' => $posts,
        ]);
    }

    #[Route('/{id}', name: 'blog_show')]
    public function show(int $id, EntityManagerInterface $em)
    {
        $post = $em->getRepository(Post::class)->findOneBy([
            'id' => $id
        ]);

        if ($post == null) {
            $response = $this->redirectToRoute('blog_list');
            return $response;
        }

        return $this->render("blog/show.html.twig", [
            'post' => $post,
        ]);
    }

}
