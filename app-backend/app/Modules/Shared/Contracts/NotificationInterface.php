<?php

namespace App\Modules\Shared\Contracts;

interface NotificationInterface
{
    public function send(string $recipient, string $subject, string $message): bool;
}
