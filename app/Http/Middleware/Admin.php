<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Support\Facades\View;

class Admin
{
    public function handle($request, Closure $next)
    {
        View::addLocation(resource_path('admin/views'));

        return $next($request);
    }
}
