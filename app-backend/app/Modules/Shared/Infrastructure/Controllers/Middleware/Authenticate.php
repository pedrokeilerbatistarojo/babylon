<?php

namespace App\Shared\Infrastructure\Controllers\Middleware;

use App\Shared\Domain\Dtos\ResponseObject;
use App\Shared\Infrastructure\Controllers\Middleware\Traits\TraitMustAuthenticate;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    use TraitMustAuthenticate;

    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  string[]  ...$guards
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {

        $mustAuth = $this->mustAuthenticate($request);

        if (! auth()->check() && $mustAuth) {

            $headers = [];

            // User is not authenticated, return 401
            $object = new ResponseObject;
            $object->message = 'Unauthenticated';
            $object->success = false;
            $object->payload = ['status' => Response::HTTP_UNAUTHORIZED];

            return $this->responseFactory->json(
                $object,
                Response::HTTP_UNAUTHORIZED,
                $headers
            );
        }

        // User is authenticated, allow the request to proceed
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : '/';
    }
}
