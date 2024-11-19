<?php

namespace App\Modules\Auth\Infrastructure\Controllers;

use App\Modules\Auth\Application\Usecases\LoginUsecase;
use App\Modules\Shared\Infrastructure\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function __construct(LoginUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->useCase->setPayload($request->all());

        return $this->handleResponse(
            $request,
            'User login successfully.',
            //'Invalid user or password'
        );
    }
}
