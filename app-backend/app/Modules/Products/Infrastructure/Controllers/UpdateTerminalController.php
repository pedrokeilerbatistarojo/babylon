<?php

namespace App\Terminals\Infrastructure\Controllers;

use App\Shared\Domain\Dtos\UpdateInputObject;
use App\Shared\Infrastructure\Controllers\BaseController;
use App\Terminals\Application\Usecases\UpdateTerminalUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTerminalController extends BaseController
{
    public function __construct(UpdateTerminalUsecase $useCase)
    {
        $this->useCase = $useCase;
        $useCase->setLimitUpdate(true);
    }

    /**
     * @throws \Exception
     */
    public function __invoke(int $id, Request $request): JsonResponse
    {

        $payload = new UpdateInputObject;
        $payload->id = $id;
        $payload->data = $request->all();
        $this->useCase->setPayload($payload);

        return $this->handleResponse($request, 'Business update successfully.');
    }
}
