<?php

namespace App\Modules\Shared\Contracts;

interface KeyPairGeneratorInterface
{
    public function getPublicKey(): string;

    public function getPrivateKey(): string;
}
