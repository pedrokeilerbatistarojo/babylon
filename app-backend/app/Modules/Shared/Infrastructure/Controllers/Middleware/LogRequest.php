<?php

namespace App\Shared\Infrastructure\Controllers\Middleware;

use App\Shared\Infrastructure\Logs\Listeners\TraitLogger;
use Closure;
use Illuminate\Http\Request;

class LogRequest
{
    use TraitLogger;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next): mixed
    {
        $response = $next($request);
        $route = $request->route();
        $allowLog = config('modules.log.http');

        if ($allowLog && $route) {

            $httpMethod = $request->method();
            $method = $route->getActionMethod();
            $controller = $route->controller ? get_class($route->controller) : '';
            $url = $request->url();

            if (str_contains($url, 'telescope')) {
                return $response;
            }

            if ($method == $controller) {
                $method = '__invoke';
            }

            $log = '['.date('Y-m-d H:i:s').']'.PHP_EOL;
            $log .= $httpMethod.': '.$url.PHP_EOL;
            $log .= 'Controller: '.$controller.'::'.$method.PHP_EOL;

            if ($route->hasParameters()) {
                $parameters = $route->parameters();
                $parameters = json_encode($parameters, JSON_PRETTY_PRINT);
                $log .= 'Parameters:'.PHP_EOL;
                $log .= $parameters.PHP_EOL.PHP_EOL;
            }

            $body = $request->all();
            if ($body) {
                $body = json_encode($body, JSON_PRETTY_PRINT);
                $log .= 'Body:'.PHP_EOL;
                $log .= $body.PHP_EOL.PHP_EOL;
            } else {
                $log .= PHP_EOL.PHP_EOL;
            }

            $this->storeLog('http-request', $log);
        }

        return $response;
    }
}
