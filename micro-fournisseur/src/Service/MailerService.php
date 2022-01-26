<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MailerService
{

    private HttpClientInterface $client;
    private string $api_url = 'http://10.176.131.75:8000';

    public function __construct(
        HttpClientInterface $client,
    ) {
        $this->client = $client;
    }

    public function send(string $to, string $subject, string $message)
    {
        try {
            $response = $this->client->request(
                'POST',
                $this->api_url . "/mailer/sendMail",
                [
                    'json' => [
                        "sender"        => "fournisseur@microservices.cesi.fr",
                        "recievers"     => ["test.test@test.fr"],
                        "content"       => $message,
                        "object"        => $subject,
                        //"CC"            => ["cc@mail.fr"],
                        //"CCi"           => ["CCi@mail.fr"],
                        //"priority"      => false,
                        //"attachments"   => ["disk/path/file.pdf"]
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
