<?php

namespace App\Tests;

use App\Entity\Planete;
use App\Service\EncryptService;
use App\Service\NasaService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EncryptionIntegrationTest extends KernelTestCase
{

    public function test1()
    {
        self::bootKernel();
        $container = static::getContainer();
        $encrypt = $container->get(EncryptService::class);

        $data = "toto";
        $this->assertEquals(
            "[CRYPTED]".$data,
            $encrypt->encrypt($data)
        );
    }

    public function test2()
    {
        self::bootKernel();
        $container = static::getContainer();
        $nasa = $container->get(NasaService::class);

        $planete = new Planete();
        $planete->name = "mars";

        $images = $nasa->getPlaneteImages($planete);
        $this->assertGreaterThan(0, count($images));
    }







}
