<?php

namespace App\Controller;

use App\Entity\Planete;
use App\Service\NasaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaneteController extends AbstractController
{

    #[Route('/planetes/add', name: 'planete_add')]
    public function add(EntityManagerInterface $em)
    {
        $planete = new Planete();
        $planete->nom = "Terre";
        $planete->taille = 12000;
        $planete->distance = 150000000;

        $em->persist($planete);
        $em->flush();

        return new Response();
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







}
