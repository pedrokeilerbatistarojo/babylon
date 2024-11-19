<?php

namespace App\Modules\Shared\Infrastructure\Utils;

class DumpServerHelper
{
    public static function dump(mixed $data): void
    {
        if (self::isDumpServerIsRunning()) {
            dump($data);
        }
    }

    public static function isDumpServerIsRunning(): bool
    {
        $ip = '127.0.0.1';
        $port = 9912;
        $timeout = 1; // Timeout in seconds

        $connection = @fsockopen($ip, $port, $errno, $errstr, $timeout);

        if (is_resource($connection)) {
            fclose($connection);
        } else {
            return false;
        }

        return true;
    }
}
