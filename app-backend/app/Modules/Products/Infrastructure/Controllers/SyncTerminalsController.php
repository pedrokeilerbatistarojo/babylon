<?php

namespace App\Terminals\Infrastructure\Controllers;

use App\Shared\Infrastructure\Controllers\BaseController;
use App\Terminals\Application\Usecases\SyncTerminalsUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncTerminalsController extends BaseController
{
    public function __construct(SyncTerminalsUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->handleResponse($request, 'Terminals synchronized successfully.');
    }
}
