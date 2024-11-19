<?php

namespace App\Shared\Infrastructure\Services;

use Exception;
use Throwable;

class PaymentProviderResponseException extends Exception
{
    public array $errors = [];

    public function __construct(array $errors, string $message, int $code = 0, ?Throwable $previous = null)
    {
        $this->errors = $errors;

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
