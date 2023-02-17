<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class YasspTest extends WebTestCase
{
    public function test1()
    {
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/planetes/1');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mercure');
    }
}
