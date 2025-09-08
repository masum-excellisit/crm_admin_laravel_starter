<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $this->isAdminUser(Auth::user())) {
            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Check if user has admin access (any role except CUSTOMER and SELLER)
     */
    private function isAdminUser($user)
    {
        if (!$user || !$user->roles->count()) {
            return false;
        }

        // Check if user has any role that is not CUSTOMER or SELLER
        $adminRoles = $user->roles->filter(function ($role) {
            return !in_array($role->name, ['CUSTOMER', 'SELLER']);
        });

        return $adminRoles->count() > 0;
    }
}
