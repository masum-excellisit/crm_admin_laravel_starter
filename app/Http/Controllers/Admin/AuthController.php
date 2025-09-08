<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check() && $this->isAdminUser(Auth::user())) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function redirectAdminLogin()
    {
        return redirect()->route('admin.login');
    }

    public function loginCheck(Request $request)
    {
       // return $request->all();
        $request->validate([
            'email'    => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8'
        ]);
        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            $user = User::where('email', $request->email)->select('id', 'email', 'status')->first();
            if ($this->isAdminUser($user) && $user->status == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Access denied or account inactive!');
            }
        } else {
            return redirect()->back()->with('error', 'Email id & password was invalid!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
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
