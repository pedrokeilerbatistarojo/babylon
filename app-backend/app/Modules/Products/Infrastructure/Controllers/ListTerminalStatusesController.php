<?php

namespace App\Terminals\Infrastructure\Controllers;

use App\Shared\Domain\Dtos\SearchRequest;
use App\Shared\Infrastructure\Controllers\BaseController;
use App\Terminals\Application\Usecases\ListTerminalStatusUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListTerminalStatusesController extends BaseController
{
    public function __construct(ListTerminalStatusUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $input = $request->all();
        $this->useCase->setPayload(new SearchRequest($input));

        return $this->handleResponse($request, 'It has been search business successfully.');
    }
}
