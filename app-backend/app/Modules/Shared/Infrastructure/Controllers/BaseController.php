<?php

namespace App\Modules\Shared\Infrastructure\Controllers;

use App\Modules\Shared\Domain\Dtos\ResponseObject;
use App\Modules\Shared\Domain\Exceptions\ValidationException;
use App\Modules\Shared\Infrastructure\Utils\DumpServerHelper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected ?object $useCase = null;

    protected int $responseStatus = Response::HTTP_OK;

    protected function handleResponse(int|Request $request, string $successMessage = '', string $errorMessage = ''): JsonResponse
    {

        try {
            $dto = $this->useCase->execute();

            return $this->sendResponse($dto, $successMessage, $this->responseStatus);
        } catch (\Throwable $ex) {

            DumpServerHelper::dump($ex);

            $errors = [];
            $statusCode = Response::HTTP_BAD_REQUEST;
            $message = $ex->getMessage();

            if ($ex instanceof ValidationException) {
                $errors = $ex->errors;
            }

            if ($ex instanceof NotFoundHttpException || $ex instanceof ModelNotFoundException) {
                $errors = [];
                $message = 'Item not found.';
                $statusCode = Response::HTTP_NOT_FOUND;
            }

            if (strlen($errorMessage)) {
                $message = $errorMessage;
                array_unshift($errors, $errorMessage);
            }

            return $this->sendError($message, $errors, $statusCode);
        }

    }

    /**
     * Success response method.
     */
    public function sendResponse(mixed $payload, string $message = '', int $code = Response::HTTP_OK): JsonResponse
    {

        $responseObj = null;
        if ($payload instanceof AnonymousResourceCollection) {

            $resource = $payload->resource;
            if ($resource instanceof LengthAwarePaginator) {

                $paginationData = [
                    'currentPage' => $payload->currentPage(),
                    'lastPage' => $payload->lastPage(),
                    'itemsPerPage' => $payload->perPage(),
                    'total' => $payload->total(),
                ];

                $payload = [
                    'items' => $resource->items(),
                    'metadata' => $paginationData,
                    'total' => $resource->total(),
                ];
            } else {

                $count = $payload->count();
                $data = $payload;

                $paginationData = [
                    'currentPage' => 1,
                    'lastPage' => 1,
                    'itemsPerPage' => $count,
                    'total' => $count,
                ];

                $payload = [
                    'items' => $data,
                    'metadata' => $paginationData,
                    'total' => $count,
                ];
            }
        }

        if ($payload instanceof ResponseObject) {
            $responseObj = $payload;
        } else {
            $responseObj = new ResponseObject;
            $responseObj->payload = $payload;
        }

        if (! $responseObj->message) {
            $responseObj->message = $message;
        }

        return response()->json($responseObj, $code);
    }

    /**
     * return error response.
     */
    public function sendError(string $message, array $errors = [], int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {

        $responseObj = new ResponseObject;
        $responseObj->success = false;
        $responseObj->message = $message;
        $responseObj->errors = count($errors) ? $errors : [$message];

        return response()->json($responseObj, $code);
    }
}
