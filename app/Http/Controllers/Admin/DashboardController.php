<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginSession;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $count['customer'] = User::role('CUSTOMER')->count();

    // Latest login sessions
    $loginSessions = LoginSession::with('user') // eager load the user
        ->latest('login_at')
        // ->take(10)
        ->paginate(10);

    return view('admin.dashboard', compact('count', 'loginSessions'));
}

}
