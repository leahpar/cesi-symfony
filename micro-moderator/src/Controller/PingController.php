<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{

    #[Route('/ping', name: 'ping')]
    public function ping()
    {
        return new Response(null, 200);
    }
}
