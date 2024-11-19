<?php

namespace App\Shared\Infrastructure\Services;

use App\Shared\Contracts\KeyPairGeneratorInterface;
use Exception;

class KeyPairGenerator implements KeyPairGeneratorInterface
{
    private string $publicKey = '';

    private string $privateKey = '';

    /**
     * @throws Exception
     */
    public function __construct()
    {
        // Generate public/private key pair
        $config = [
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            //"config" => "C:/dev/lang/php/8.2.0/extras/ssl/openssl.cnf",
        ];
        $keyPair = openssl_pkey_new($config);
        if (! $keyPair) {
            throw new Exception(openssl_error_string());
        }

        // Extract public/private key
        $export = openssl_pkey_export($keyPair, $this->privateKey, null, $config);
        if (! $export) {
            throw new Exception(openssl_error_string());
        }

        $details = openssl_pkey_get_details($keyPair);
        if (! $details) {
            throw new Exception(openssl_error_string());
        }

        $this->publicKey = $details['key'];
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }
}
