<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class LogService
{
    private HttpClientInterface $client;
    private string $api_url = 'https://10.176.131.23:8000/api';

    public function __construct(
        HttpClientInterface $client,
    ) {
        $this->client = $client;
    }

    public function log(string $niveau, string $message)
    {
        try {
            $response = $this->client->request(
                'POST',
                $this->api_url . "/logs",
                [
                    'json' => [
                        //'niveau' => $niveau,
                        'message' => $message,
                    ]
                ]
            );
            return $response->getStatusCode();
        }
        catch (\Exception $e) {
            dump($e);
        }
        return null;
    }

}
