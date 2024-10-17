<?php

namespace Sellvation\CCMV2\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sellvation\CCMV2\Users\Models\User;

class LoginController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt([
            'name' => $credentials['name'],
            'password' => $credentials['password'],
            function (Builder $query) {
                $query->where('is_active', '>', 0)
                    ->where('is_system', 0)
                    ->where(fn (Builder $query) => $query->whereNull('expiration_date')
                        ->orWhereDate('expiration_date', '>', now())
                    );
            },
        ])) {
            if ($user = User::where('name', $credentials['name'])
                ->where('old_password', sha1(md5($credentials['password'])))
                ->where('is_active', 1)
                ->where('is_system', 0)
                ->where(fn (Builder $query) => $query->whereNull('expiration_date')
                    ->orWhereDate('expiration_date', '>', now())
                )
                ->first()) {
                Auth::login($user);

                $user->password = bcrypt($credentials['password']);
                $user->old_password = null;
                $user->save();
            }
        }

        if (Auth::check()) {
            $request->session()->regenerate();

            $user = Auth::user();

            $user->first_login = $user->first_login ?: now();
            $user->last_login = now();
            $user->save();

            $environment = $user->customer->environments()->first();
            \Session::put('environment_id', $environment->id);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ])->onlyInput('name');
    }
}
