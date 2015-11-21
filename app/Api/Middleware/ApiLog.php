<?php

namespace App\Api\Middleware;

use App\Log;
use Closure;

class ApiLog
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        Log::record('api', $request->path());

        return $response;
    }
}
