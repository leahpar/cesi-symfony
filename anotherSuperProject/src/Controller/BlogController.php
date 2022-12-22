<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/blog")]
class BlogController extends AbstractController
{

//    #[Route("/add", name: 'blog_add')]
//    public function add(EntityManagerInterface $em)
//    {
//        $post = new Post();
//        $post->title = "Mon 3e post !";
//        $post->content = "Lorem ipsum...";
//
//        $em->persist($post);
//        $em->flush();
//
//        $response = $this->redirectToRoute('blog_list');
//        return $response;
//    }

    #[Route("/add", name: 'blog_add')]
    public function add(Request $request, EntityManagerInterface $em)
    {
        // Nouveau Post "vierge"
        $post = new Post();

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

            // On redirige vers l'affichage du post par exemple
            return $this->redirectToRoute('blog_show', ['id' => $post->id]);
        }
        // Affichage
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}/edit", name: 'blog_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $em)
    {
        // Création formulaire
        $form = $this->createForm(PostType::class, $post);

        // "Remplissage" du formulaire depuis la requête
        $form->handleRequest($request);

        // Si formulaire soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // ici, $post contient les données soumises

            // On enregistre
            //$em->persist($post);
            $em->flush();

            // On redirige vers l'affichage du post par exemple
            return $this->redirectToRoute('blog_show', ['id' => $post->id]);
        }
        // Affichage
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'blog_list')]
    public function list(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Post::class)->findAll();
        return $this->render("blog/posts.html.twig", [
            'posts' => $posts,
        ]);
    }

//    #[Route('/{id}', name: 'blog_show')]
//    public function show(int $id, EntityManagerInterface $em)
//    {
//        $post = $em->getRepository(Post::class)->findOneBy([
//            'id' => $id
//        ]);
//
//        if ($post == null) {
//            //$response = $this->redirectToRoute('blog_list');
//            //return $response;
//
//            //return new Response(null, 404);
//
//            throw new NotFoundHttpException("id $id inexistant");
//        }
//
//        return $this->render("blog/show.html.twig", [
//            'post' => $post,
//        ]);
//    }

    #[Route('/{id}', name: 'blog_show')]
    public function show(Post $post)
    {
        return $this->render("blog/show.html.twig", [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/delete', name: 'blog_delete')]
    public function delete(Post $post, EntityManagerInterface $em)
    {
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('blog_list');
    }

}
