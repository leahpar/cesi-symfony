<?php

namespace App\Service;

class EncryptService
{

    public function encrypt(?string $s): ?string
    {
        return "[CRYPTED]" . $s;
    }

    public function decrypt(?string $s): ?string
    {
        return str_replace("[CRYPTED]", "", $s);
    }


}
