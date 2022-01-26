<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommsService
{
    private HttpClientInterface $client;
    private string $api_url = 'http://10.176.130.115';

    public function __construct(
        HttpClientInterface $client,
    ) {
        $this->client = $client;
    }

    public function getComms()
    {
        $response = $this->client->request(
            'GET',
            $this->api_url . '/commentsNotValidated'
        );
        //dump(json_decode($response->getContent()));
        $data = json_decode($response->getContent(), true);
        return $data;

    }

    public function updateComm($id, $commentaire, $valide)
    {
        $response = $this->client->request(
            'PUT',
            $this->api_url . '/comment/' . $id,
            [
                'json' => [
                'comment' => $commentaire,
                'validated' => $valide,
            ]]
        );

    }

    public function getComm()
    {
        return [];
    }

}
