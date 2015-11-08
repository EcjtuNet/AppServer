<?php

namespace App\Api\Middleware;

use Closure;
use App\Log;

class ApiLog
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        Log::record('api', $request->path());
        return $response;
    }
}
