<?php

// app/Http/Middleware/UpdateLastActivity.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginSession;

class UpdateLastActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $ip = $request->ip();

            LoginSession::where('user_id', $user->id)
                ->where('ip_address', $ip)
                ->whereNull('logout_at')
                ->latest('login_at')
                ->limit(1)
                ->update([
                    'updated_at' => now(), // optional
                ]);
        }

        return $next($request);
    }
}
