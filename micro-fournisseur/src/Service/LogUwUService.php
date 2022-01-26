<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class LogUwUService
{
    private HttpClientInterface $client;
    private string $api_url = 'http://10.176.131.94:80/api';

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
                        'datetime' => (new \DateTime())->format('Y-m-d H:i'),
                        'tag' => $niveau,
                        'description' => $message,
                        'idUtilisateur' => 'fournisseur',
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
