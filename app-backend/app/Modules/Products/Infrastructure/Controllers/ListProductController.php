<?php

namespace App\Modules\Products\Infrastructure\Controllers;

use App\Modules\Products\Application\Usecases\ListProductUsecase;
use App\Modules\Shared\Infrastructure\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Pedrokeilerbatistarojo\Smartfilter\Helpers\ResponseHelper;

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
        try {
            $response = $this->useCase->execute($request->all());
            return ResponseHelper::sendResponse($response);
        }
        catch(\Exception $ex){
            return ResponseHelper::sendError($ex->getMessage());
        }
    }
}
