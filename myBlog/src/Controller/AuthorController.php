<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AuthorType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/authors')]
#[isGranted('ROLE_ADMIN')]
class AuthorController extends AbstractController
{
    #[Route('/', name: 'author_index', methods: ['GET'])]
    public function index(UserRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/new', name: 'author_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new User();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'author_show', methods: ['GET'])]
    public function show(User $author): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: 'author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $author, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'author_delete', methods: ['POST'])]
    public function delete(Request $request, User $author, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('author_index', [], Response::HTTP_SEE_OTHER);
    }
}
