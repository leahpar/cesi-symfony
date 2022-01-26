<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FilmService
{
    private HttpClientInterface $client;
    private string $api_url = 'http://10.176.131.68:8000/api';

    public function __construct(
        HttpClientInterface $client,
    ) {
        $this->client = $client;
    }

    public function listFilms(): ?array
    {
        $response = $this->client->request(
            'GET',
            $this->api_url . '/films'
        );
        //dump(json_decode($response->getContent()));
        $data = json_decode($response->getContent(), true);
        return $data['hydra:member'];
    }

    public function getFilm(int $id): ?array
    {
        $response = $this->client->request(
            'GET',
            $this->api_url . '/films/' . $id
        );
        //dump(json_decode($response->getContent()));
        $data = json_decode($response->getContent(), true);
        try {
            $data['publicationDate'] = (new \DateTime($data['publicationDate']))->format('Y-m-d');
        }
        catch (\Exception $e) {
            $data['publicationDate'] = null;
        }
        return $data;
    }

    public function addFilm(array $film): void
    {
        unset($film['id']);
        $response = $this->client->request(
            'POST',
            $this->api_url . '/films',
            [
                'json' => $film
            ]
        );
    }

    public function editFilm(array $film): void
    {
        $response = $this->client->request(
            'PUT',
            $this->api_url . '/films/' . $film['id'],
            [
                'json' => $film
            ]
        );
    }

    public function deleteFilm(int $film): void
    {
        $response = $this->client->request(
            'DELETE',
            $this->api_url . '/films/' . $film,
        );
    }

}
