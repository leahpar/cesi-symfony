<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hello')]
class HelloController extends AbstractController
{
    /**
     * @Route("/helloworld", name="helloworld")
     */
    public function helloworld()
    {
        //$response = new Response();
        //$response->setContent("<h1>Hello World!</h1>");
        //$response->setStatusCode(200);

        // return new Response("<h1>Hello World!</h1>");
        return $this->render(
            '/hello/hello-name.html.twig',
            [
                'name' => "World",
            ]
        );
    }

    #[Route('/hello/{name}', name: 'hello')]
    public function hello(string $name)
    {
        //return new Response(
        //    "<h1>Hello ".$name."!</h1>"
        //);
        return $this->render(
            '/hello/hello-name.html.twig',
            [
                'name' => $name,
            ]
        );
    }

    #[Route('/hello', name: 'hello_name', methods: ['GET'])]
    public function helloName(Request $request)
    {
        $name = $request->query->get('name');
        //return new Response(
        //    "<h1>Hello ".$name."!</h1>"
        //);
        return $this->render(
            '/hello/hello-name.html.twig',
            [
                'name' => $name,
            ]
        );
    }

    #[Route('/formulaire')]
    public function formulaire()
    {
        return $this->render(
            '/hello/formulaire.html.twig'
        );
    }

    #[Route('/hello', name: 'hello_name_post', methods: ['POST'])]
    public function helloNamePost(Request $request)
    {
        $name = $request->request->get('name');
        return $this->render(
            '/hello/hello-name.html.twig',
            [
                'name' => $name,
            ]
        );
    }


}

