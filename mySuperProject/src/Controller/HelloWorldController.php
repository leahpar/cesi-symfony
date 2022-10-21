<?php

namespace App\Controller;

use App\Service\Random;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello', name: 'hello_world')]
    public function helloWorld(Request $request)
    {
        //$response = new Response();
        //$response->setContent("<h1>Hello World 2!</h1>");
        //$response->setStatusCode(200);
        //return $response;

        $response = $this->render('helloworld/hello.html.twig');
        return $response;
    }

    #[Route('/hello/{name}', name: 'hello_name')]
    public function helloName(Request $request, string $name)
    {
        //$response = new Response();
        //$response->setContent("<h1>Hello $name !</h1>");
        //$response->setStatusCode(200);
        //return $response;

        $response = $this->render('helloworld/hello.html.twig', [
            'name' => $name,
        ]);
        return $response;

    }

    #[Route('/random')]
    public function random(Random $random)
    {
        $nombre = $random->getAnotherRandomNumber();
        $response = new Response('<h1>'.$nombre.'</h1>');
        return $response;
    }

}
