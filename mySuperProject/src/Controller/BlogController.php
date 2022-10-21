<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{

    #[Route('/', name: 'posts')]
    public function listPosts(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Post::class)->findAll();

        $response = $this->render('blog/posts.html.twig', [
            'posts' => $posts,
        ]);

        return $response;
    }

    #[Route('/{id}', name: 'post', requirements: ['id' => '\d+'])]
    public function getPost(Post $post, EntityManagerInterface $em)
    {
        /** @var Post $post */
        //$post = $em->getRepository(Post::class)->findOneBy(['id' => $id]);

        return $this->render('blog/post.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/delete', name: 'post_delete')]
    public function deletePost(Post $post, EntityManagerInterface $em)
    {
        ///** @var Post $post */
        //$post = $em->getRepository(Post::class)->findOneBy(['id' => $id]);

        $em->remove($post);
        $em->flush();

        $response = $this->redirectToRoute('blog_posts');
        return $response;
    }

    /*
    public function addPost(Request $request, EntityManagerInterface $em)
    {
        if ($request->isMethod("POST")) {
            $post = new Post();
            $post->title = $request->request->get('title');
            $post->content = $request->request->get('content');
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_post', [
                'id' => $post->id,
            ]);
        }

        return $this->render('blog/new.html.twig', [
            'post' => new Post()
        ]);
    }
    */

    #[Route('/add', name: 'post_add')]
    #[Route('/{id}/edit', name: 'post_edit')]
    public function editPost(Request $request,
                             EntityManagerInterface $em,
                             ?Post $post = null
    ) {
        $post = $post ?? new Post();

        $postForm = $this->createForm(PostType::class, $post);

        $postForm->handleRequest($request);

        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_post', [
                'id' => $post->id,
            ]);
        }

        return $this->render('blog/new.html.twig', [
            'post' => $post,
            'postForm' => $postForm->createView(),
        ]);
    }

}
