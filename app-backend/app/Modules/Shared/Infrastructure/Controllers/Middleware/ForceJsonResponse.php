<?php

namespace App\Shared\Infrastructure\Controllers\Middleware;

use App\Shared\Domain\Dtos\ResponseObject;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class ForceJsonResponse
{
    protected ResponseFactory $responseFactory;

    /**
     * JsonResponseMiddleware constructor.
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $url = $request->getRequestUri();

        if (! str_contains($url, '/api')) {
            return $next($request);
        }

        // First, set the header so any other middleware knows we're
        // dealing with a should-be JSON response.
        $request->headers->set('Accept', 'application/json');

        // Get the response
        $response = $next($request);

        // If the response is not strictly a JsonResponse, we make it
        if (! $response instanceof JsonResponse) {

            $object = new ResponseObject;
            $object->success = $response->isSuccessful();
            $object->payload = ['status' => $response->getStatusCode()];

            $response = $this->responseFactory->json(
                $object,
                $response->status(),
                $response->headers->all()
            );
        }

        return $response;
    }
}
