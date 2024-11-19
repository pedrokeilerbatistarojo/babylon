<?php

namespace App\Modules\Auth\Application\Usecases;

use Throwable;

class LogoutUsecase
{
    public function execute(): bool
    {

        try {
            \Auth::logout();

            return true;
        } catch (Throwable $e) {
            return false;
        }

    }
}
