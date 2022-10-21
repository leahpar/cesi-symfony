<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDemoController extends AbstractController
{

    #[Route('demoapi')]
    public function demoApi(HttpClientInterface $client)
    {
        $reqHttp = $client->request('GET', "https://swapi.dev/api/people/".rand(1,100));

        if ($reqHttp->getStatusCode() != 200) {
            throw new NotFoundHttpException();
        }

        //$json = $reqHttp->getContent();
        //$people = json_decode($json, true);

        $people = $reqHttp->toArray(false);

        return $this->render('demoapi/people.html.twig', [
            'people' => $people,
        ]);
    }

}
