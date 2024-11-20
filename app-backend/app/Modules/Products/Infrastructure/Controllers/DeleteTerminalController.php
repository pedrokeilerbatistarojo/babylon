<?php

namespace App\Terminals\Infrastructure\Controllers;

use App\Shared\Domain\Dtos\ShowInputObject;
use App\Shared\Infrastructure\Controllers\BaseController;
use App\Terminals\Application\Usecases\DeleteTerminalUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteTerminalController extends BaseController
{
    public function __construct(DeleteTerminalUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {

        $payload = new ShowInputObject;
        $payload->id = $id;
        $this->useCase->setPayload($payload);

        return $this->handleResponse($request, 'User update successfully.');
    }
}
