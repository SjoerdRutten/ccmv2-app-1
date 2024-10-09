<?php

namespace Sellvation\CCMV2\Ccm\Http\Middelware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

class CcmContextMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::check()) {
            Context::add('user_id', \Auth::id());
            Context::add('environment_id', \Auth::user()->currentEnvironmentId);
        }

        return $next($request);
    }
}
