<?php

namespace App\Shared\Contracts\Log;

use Throwable;

interface ExceptionLoggingServiceInterface
{
    /**
     * Store an Exception.
     *
     * @param  Throwable  $exception
     * @return bool
     */
    public static function logException(Throwable $exception): bool;
}
