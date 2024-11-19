<?php

namespace App\Shared\Infrastructure\Controllers\Middleware\Traits;

use Illuminate\Http\Request;

trait TraitMustAuthenticate
{
    private function mustAuthenticate(Request $request)
    {

        $url = $request->getRequestUri();
        $urls = [
            '/api/auth/login',
            '/api/transactions/listener',
            '/api/transactions/seeder',
        ];

        if (in_array($url, $urls)) {
            return false;
        }

        return str_contains($url, '/api');
    }
}
