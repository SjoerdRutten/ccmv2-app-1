<?php

namespace Sellvation\CCMV2\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request, StatefulGuard $guard)
    {
        $guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('ccm::dashboard');
    }
}
