<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserActivityController extends Controller
{


    public function ipTracking(Request $request)
    {
        $query = UserActivity::with('user')
            ->latest('activity_at');

        // Filters
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->activity_type) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->ip_address) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        if ($request->date_from) {
            $query->whereDate('activity_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('activity_at', '<=', $request->date_to);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $request->search . '%')
                    ->orWhere('device_type', 'like', '%' . $request->search . '%')
                    ->orWhere('browser', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($subQ) use ($request) {
                        $subQ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $activities = $query->paginate(15);

        // Statistics
        $stats = [
            'total_activities' => UserActivity::count(),
            'unique_ips' => UserActivity::distinct('ip_address')->count(),
            'unique_users' => UserActivity::distinct('user_id')->count(),
            'today_activities' => UserActivity::whereDate('activity_at', today())->count()
        ];

        // Top IPs
        $topIPs = UserActivity::select('ip_address', DB::raw('count(*) as activity_count'))
            ->groupBy('ip_address')
            ->orderByDesc('activity_count')
            ->limit(10)
            ->get();

        // Activity types breakdown
        $activityTypes = UserActivity::select('activity_type', DB::raw('count(*) as count'))
            ->groupBy('activity_type')
            ->orderByDesc('count')
            ->get();

        $users = User::role('CUSTOMER')->get();

        return view('admin.user-activity.ip-tracking', compact('activities', 'stats', 'topIPs', 'activityTypes', 'users'));
    }
}
