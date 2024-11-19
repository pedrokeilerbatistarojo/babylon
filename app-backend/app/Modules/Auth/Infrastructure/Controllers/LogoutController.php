<?php

namespace App\Modules\Auth\Infrastructure\Controllers;

use App\Modules\Auth\Application\Usecases\LogoutUsecase;
use App\Modules\Shared\Infrastructure\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
    public function __construct(LogoutUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * Login api
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->handleResponse($request, 'User logout successfully.');
    }
}
