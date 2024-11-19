<?php

namespace App\Modules\Shared\Utils;

use Exception;

class JwtUtil
{
    public static function decodeJWT(string $jwt): array
    {
        // Split the JWT into its three parts
        $jwtParts = explode('.', $jwt);

        if (count($jwtParts) !== 3) {
            throw new Exception('Invalid JWT format.');
        }

        // Decode Header
        $header = json_decode(self::base64UrlDecode($jwtParts[0]), true);

        // Decode Payload
        $payload = json_decode(self::base64UrlDecode($jwtParts[1]), true);

        // The third part is the signature, which is not needed for basic decoding
        $signature = $jwtParts[2];

        return [
            'header' => $header,
            'payload' => $payload,
            'signature' => $signature,
        ];
    }

    // Helper function for decoding Base64Url encoded strings
    public static function base64UrlDecode(string $data): string
    {
        // Replace URL-safe characters and add padding if necessary
        $base64 = str_replace(['-', '_'], ['+', '/'], $data);
        $padLength = 4 - (strlen($base64) % 4);

        if ($padLength < 4) {
            $base64 .= str_repeat('=', $padLength);
        }

        return base64_decode($base64);
    }
}
