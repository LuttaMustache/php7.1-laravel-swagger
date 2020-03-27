<?php

namespace LuttaMustache\Support\AutoDoc\Http\Middleware;

use Closure;
use LuttaMustache\Support\AutoDoc\Services\SwaggerService;

/**
 * @property SwaggerService $service
*/
class AutoDocMiddleware
{
    protected $service;
    public static $skipped = false;

    public function __construct()
    {
        $this->service = app(SwaggerService::class);
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ((config('app.env') == 'testing') && !self::$skipped) {
            $this->service->addData($request, $response);
        }

        self::$skipped = false;

        return $response;
    }
}