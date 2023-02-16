<?php

namespace App\Controller;

use App\Entity\Planete;
use App\Form\PlaneteType;
use App\Service\NasaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlaneteController extends AbstractController
{

    #[Route('/planetes/add', name: 'planete_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em)
    {
        $planete = new Planete();
        $form = $this->createForm(PlaneteType::class, $planete);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($planete);
            $em->flush();

            return $this->redirectToRoute('planete_show', [
                'id' => $planete->id,
            ]);
        }

        return $this->render('planetes/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/planetes', name: 'planetes_list')]
    public function list(EntityManagerInterface $em)
    {
        $planetes = $em->getRepository(Planete::class)->findAll();

        return $this->render('planetes/list.html.twig', [
            'planetes' => $planetes,
        ]);
    }

    #[Route('/planetes/{id}', name: 'planete_show')]
    public function show(Planete $planete, NasaService $nasa)
    {
        //$planete = $em->getRepository(Planete::class)->findOneBy([
        //    'id' => $id,
        //]);
        //if ($planete == null) {
        //    //return new Response(null, 404);
        //    throw new NotFoundHttpException();
        //}

        $items = $nasa->getPlaneteImages($planete);

        return $this->render('planetes/show.html.twig', [
            'planete' => $planete,
            'items' => $items
        ]);
    }

    #[Route('/planetes/{id}/edit', name: 'planete_edit', methods: ['GET', 'POST'])]
    public function edit(Planete $planete, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(PlaneteType::class, $planete);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$em->persist($planete);
            $em->flush();

            return $this->redirectToRoute('planete_show', [
                'id' => $planete->id,
            ]);
        }

        return $this->render('planetes/form.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/planetes/{id}/delete', name: 'planete_del')]
    public function del(Planete $planete, EntityManagerInterface $em)
    {
        $em->remove($planete);
        $em->flush();

        return $this->redirectToRoute('planetes_list');
    }

}
