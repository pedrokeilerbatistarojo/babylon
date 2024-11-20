<?php

namespace App\Modules\Products\Infrastructure\Controllers;

use App\Modules\Products\Application\Usecases\ListProductUsecase;
use App\Modules\Shared\Domain\Dtos\SearchRequest;
use App\Modules\Shared\Infrastructure\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListProductController extends BaseController
{
    public function __construct(ListProductUsecase $useCase)
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

        return $this->handleResponse($request, 'It has been search terminal successfully.');
    }
}
