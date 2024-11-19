<?php

namespace App\Shared\Infrastructure\Controllers\Middleware;

use App\Shared\Domain\Dtos\ResponseObject;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        $user = $request->user();
        $role = $user?->role;

        /*dump([
            'user' => $user?->id,
            'role' => $role?->name,
            'roles' => $roles,
        ]);*/

        if (! $user || ! in_array($role?->name, $roles)) {
            $headers = [];

            // User is not authenticated, return 401
            $object = new ResponseObject;
            $object->message = 'Unauthorized';
            $object->success = false;
            $object->payload = ['status' => Response::HTTP_UNAUTHORIZED];

            $response = $this->responseFactory->json(
                $object,
                Response::HTTP_FORBIDDEN,
                $headers
            );

            return $response;
        }

        return $next($request);
    }
}
