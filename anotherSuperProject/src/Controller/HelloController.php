<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    #[Route('hello_world', name: 'hello_world')]
    public function helloWorld()
    {
        $response = new Response();
        $response->setContent("<h1>Hello World!</h1>");
        //$response->setContent("<html><body><h1>Hello World!</h1></body></html>");
        $response->setStatusCode(200);
        return $response;
    }

}
