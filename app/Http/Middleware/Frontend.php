<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class Frontend
{
    public function handle($request, Closure $next)
    {
        View::addLocation(resource_path('frontend/views'));

        return $next($request);
    }
}
