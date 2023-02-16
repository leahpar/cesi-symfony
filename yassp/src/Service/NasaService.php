<?php

namespace App\Service;

use App\Entity\Planete;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasaService
{

    private HttpClientInterface $httpClient;
    private ?string $nasaToken = null;
    private string $nasaUser;
    private string $nasaPwd;

    public function __construct(
        HttpClientInterface $httpClient,
        string $nasaToken,
        //string $nasaUser,
        //string $nasaPwd
    ) {
        $this->httpClient = $httpClient;
        //$this->nasaUser = $nasaUser;
        //$this->nasaPwd = $nasaPwd;
        $this->nasaToken = $nasaToken;
    }

    public function getClient()
    {
        //if ($this->nasaToken == null) {
        //    $response = $this->httpClient->request(
        //        'POST',
        //        'https://images-api.nasa.gov/login',
        //        [
        //            'user' => $this->nasaUser,
        //            'password' => $this->nasaPwd,
        //        ]
        //    );
        //    $this->token = $response->toArray()['token'];
        //}
        return $this->httpClient;
    }

    public function getPlaneteImages(Planete $planete): array
    {
        $items = [];
        if ($planete->name != null) {
            try {
                $response = $this->getClient()->request(
                    'GET',
                    'https://images-api.nasa.gov/search?q='
                    . $planete->name . '&page=1&media_type=image'
                    //. $this->nasaToken
                );
                $items = $response->toArray()['collection']['items'];
            }
            catch (\Exception $e)
            {
                $items = [];
            }
        }
        return $items;

    }
}
