<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ModerationService
{
    private HttpClientInterface $client;
    private string $api_url = 'http://10.176.131.71:8000';

    public function __construct(
        HttpClientInterface $client,
    ) {
        $this->client = $client;
    }

    public function moderate($commentaire)
    {
        try {
            $response = $this->client->request(
                'POST',
                $this->api_url . "/moderation",
                [
                    'json' => [
                        //'niveau' => $niveau,
                        'commentaire' => $commentaire,
                    ]
                ]
            );
            $data = json_decode($response->getContent(), true);
            return $data['message'];
        }
        catch (\Exception $e) {
            dump($e);
        }
        return null;

    }


}
