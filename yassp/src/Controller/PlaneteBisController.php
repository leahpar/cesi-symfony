<?php

namespace App\Controller;

use App\Entity\Planete;
use App\Form\PlaneteType;
use App\Repository\PlaneteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/crud-auto/planetes')]
class PlaneteBisController extends AbstractController
{
    #[Route('/', name: 'app_planete_bis_index', methods: ['GET'])]
    public function index(PlaneteRepository $planeteRepository): Response
    {
        return $this->render('planete_bis/index.html.twig', [
            'planetes' => $planeteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planete_bis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlaneteRepository $planeteRepository): Response
    {
        $planete = new Planete();
        $form = $this->createForm(PlaneteType::class, $planete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planeteRepository->save($planete, true);

            return $this->redirectToRoute('app_planete_bis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planete_bis/new.html.twig', [
            'planete' => $planete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planete_bis_show', methods: ['GET'])]
    public function show(Planete $planete): Response
    {
        return $this->render('planete_bis/show.html.twig', [
            'planete' => $planete,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planete_bis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planete $planete, PlaneteRepository $planeteRepository): Response
    {
        $form = $this->createForm(PlaneteType::class, $planete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planeteRepository->save($planete, true);

            return $this->redirectToRoute('app_planete_bis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planete_bis/edit.html.twig', [
            'planete' => $planete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planete_bis_delete', methods: ['POST'])]
    public function delete(Request $request, Planete $planete, PlaneteRepository $planeteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planete->getId(), $request->request->get('_token'))) {
            $planeteRepository->remove($planete, true);
        }

        return $this->redirectToRoute('app_planete_bis_index', [], Response::HTTP_SEE_OTHER);
    }
}
