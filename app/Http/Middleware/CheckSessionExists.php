<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckSessionExists
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $session = DB::table('sessions')
                ->where('id', Session::getId())
                ->first();

            if (!$session) {
                Auth::logout();
                Session::flush();

                return redirect()->route('login')->withErrors([
                    'message' => 'You have been logged out because your session was invalidated.'
                ]);
            }
        }

        return $next($request);
    }
}
