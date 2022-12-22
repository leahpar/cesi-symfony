<?php

namespace App\Controller;

use App\Service\DumpBidonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    #[Route('/hello/world', name: 'hello_world')]
    public function helloWorld()
    {
        $response = new Response();
        $response->setContent("<html><body><h1>Hello World!</h1></body></html>");
        $response->setStatusCode(200);
        return $response;
    }

    #[Route('/hello/{nom}', name: 'hello_nom')]
    public function hello(string $nom)
    {
        // ...
        $response = $this->render("hello/hello.html.twig", [
            'nom' => $nom,
        ]);
        return $response;
    }

}
