<?php

namespace App\Modules\Auth\Infrastructure\Controllers;

use App\Modules\Auth\Application\Usecases\RefreshTokenUsecase;
use App\Modules\Shared\Infrastructure\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshTokenController extends BaseController
{
    public function __construct(RefreshTokenUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * Login api
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->useCase->setPayload($request->user());

        return $this->handleResponse($request, 'Token refresh successfully.');
    }
}
