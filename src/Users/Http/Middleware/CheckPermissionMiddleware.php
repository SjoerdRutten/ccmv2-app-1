<?php

namespace Sellvation\CCMV2\Users\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        return $next($request);

        $permission = explode('.', $permission);
        if (request()->user()->hasPermissionTo($permission[0], $permission[1].'111')) {
            return $next($request);
        }

        abort(403);
    }
}
