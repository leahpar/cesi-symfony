<?php

namespace App\Tests;

use App\Service\EncryptService;
use PHPUnit\Framework\TestCase;

class EncryptionTest extends TestCase
{

    public function test1()
    {
        $encrypt = new EncryptService();
        $data = "toto";
        $this->assertEquals(
            "[CRYPTED]".$data,
            $encrypt->encrypt($data)
        );
    }



}
