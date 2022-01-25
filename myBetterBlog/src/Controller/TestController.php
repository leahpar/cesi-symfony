<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TestController extends AbstractController
{

    #[Route('/test-api', name: 'test_api')]
    public function testApi(HttpClientInterface $client): Response
    {
        $response = $client->request(
            'GET',
            'http://php8:8019/api/posts',
        );

        dump($response->getStatusCode(), $response->getContent());

        return new Response();
    }

    #[Route('/test-post-api', name: 'test_post_api')]
    public function testPostApi(HttpClientInterface $client): Response
    {
        $post = [
            'titre' => "Un autre via l'api",
            "auteur" => "/api/users/3",
            "contenu" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum",
            "date" => "2022-01-25",
            "publie" => false,
        ];

        try {
            $response = $client->request(
                'POST',
                'http://php8:8019/api/posts',
                [
                    'json' => $post,
                    'headers' => [
                        //'Content-Type' => 'application/json',
                        'X-AUTH-TOKEN' => 'toto123',
                    ],
                ]
            );
            dump($response->getStatusCode(), $response->getContent());
        }
         catch (\Exception $e) {
            dump($e);
        }

        return new Response();
    }

}
