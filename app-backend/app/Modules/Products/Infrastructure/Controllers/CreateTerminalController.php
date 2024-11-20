<?php

namespace App\Terminals\Infrastructure\Controllers;

use App\Shared\Infrastructure\Controllers\BaseController;
use App\Terminals\Application\Usecases\CreateTerminalUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateTerminalController extends BaseController
{
    public function __construct(CreateTerminalUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->useCase->setPayload($request->all());

        return $this->handleResponse($request, 'Business create successfully.');
    }
}
