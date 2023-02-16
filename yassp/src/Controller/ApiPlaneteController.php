<?php

namespace App\Controller;

use App\Entity\Planete;
use App\Service\NasaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'api_')]
class ApiPlaneteController extends ApiController
{

    #[Route('/planetes', name: 'planetes_list')]
    public function list(EntityManagerInterface $em)
    {
        $planetes = $em->getRepository(Planete::class)->findAll();
        return $this->jsonResponse($planetes);
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
        return $this->jsonResponse($planete, $items);
    }


}
