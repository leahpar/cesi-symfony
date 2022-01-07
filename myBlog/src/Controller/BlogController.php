<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\AuthorRepository;
use App\Repository\PostRepository;
use App\Service\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/posts', name: 'post_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render('blog/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /*
    #[Route('/{id}', name: 'show', requirements:  ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $em)
    {
        $post = $em->getRepository(Post::class)->find($id);

        if ($post == null) {
            //return new Response(null, 404);
            throw new NotFoundHttpException();
        }

        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }
    */

    #[Route('/{id}', name: 'show', requirements:  ['id' => '\d+'])]
    public function show(Post $post, SessionInterface $session)
    {
        $session->set('dernier_post_id', $post->getId());
        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/last', name: 'last')]
    public function last(SessionInterface $session)
    {
        $id = $session->get('dernier_post_id', 0);

        if ($id == 0) {
            $this->addFlash('warning', 'Pas de dernier post visité');
            return $this->redirectToRoute('post_list');
        }

        return $this->redirectToRoute('post_show', [
            'id' => $id,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ["POST"])]
    public function delete(Post $post, EntityManagerInterface $em)
    {
        $em->remove($post);
        $em->flush();
        $this->addFlash('success', 'Post supprimé');
        return $this->redirectToRoute('post_list');
    }

    #[Route('/random', name: 'random')]
    public function random(PostService $service)
    {
        $post = $service->getRandomPost();
        return $this->redirectToRoute(
            'post_show',
            ['id' => $post->getId()]
        );
    }

    #[Route('/search', name: 'search', methods: ["POST"])]
    public function search(Request $request, EntityManagerInterface $em)
    {
        $value = $request->request->get('search');

        $posts = $em->getRepository(Post::class)->search($value);

        return $this->render('blog/list.html.twig', [
            'search' => $value,
            'posts' => $posts,
        ]);
    }

    /*
    #[Route('/new', name: 'new')]
    public function newPostFormulaire()
    {
        $form = $this->createForm(PostType::class);
        // ...

        return $this->render('blog/form_new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/save', name: 'save', methods: ["POST"])]
    public function newPostSave(
        Request $request,
        EntityManagerInterface $em,
    ) {

        $post = new Post();
        $post->setTitle(
            $request->request->get('title')
        );
        $post->setContent(
            $request->request->get('content')
        );
        $post->setDate(new \DateTime());

        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('post_show', [
            'id' => $post->getId()
        ]);
    }


    #[Route('/{id}/edit', name: 'edit_form')]
    public function editPostFormulaire(Post $post)
    {
        return $this->render('blog/form_edit.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/{id}/save', name: 'edit_save', methods: ["POST"])]
    public function editPostSave(
        Post $post,
        Request $request,
        EntityManagerInterface $em,
    ) {
        $post->setTitle(
            $request->request->get('title')
        );
        $post->setContent(
            $request->request->get('content')
        );
        //$post->setDate(new \DateTime());

        //$em->persist($post);
        $em->flush();

        return $this->redirectToRoute('post_show', [
            'id' => $post->getId()
        ]);
    }
    */

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function new(?Post $post, Request $request, EntityManagerInterface $em)
    {
        $post = $post ?? new Post();

        // Création formulaire
        $form = $this->createForm(PostType::class, $post);

        // "Remplissage" du formulaire depuis la requête
        $form->handleRequest($request);

        // Si formulaire soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // ici, $post contient les données soumises

            // On enregistre
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post enregistré');

            // On redirige vers l'affichage du post par exemple
            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        // Si formulaire non soumis OU formulaire invalide
        return $this->render('blog/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

}
