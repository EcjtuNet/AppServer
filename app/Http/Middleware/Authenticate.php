<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('admin') || 
            !Admin::where('username', $request->session()->get('admin'))) {
            return redirect()->route('admin_login');
        }
        return $next($request);
    }
}
