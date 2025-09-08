@extends('admin.layouts.master')
@section('title')
    IP Address Tracking - {{ env('APP_NAME') }}
@endsection

@section('head')
    User IP Address Tracking
@endsection

@section('content')
    <div class="main-content">
        <div class="inner_page">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_1">
                        <h3>{{ number_format($stats['total_activities']) }}</h3>
                        <p>Total Activities</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_2">
                        <h3>{{ $stats['unique_ips'] }}</h3>
                        <p>Unique IP Addresses</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_3">
                        <h3>{{ $stats['unique_users'] }}</h3>
                        <p>Unique Users</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_4">
                        <h3>{{ $stats['today_activities'] }}</h3>
                        <p>Today's Activities</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-2">
                            <select name="user_id" class="form-select">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="activity_type" class="form-select">
                                <option value="">All Activities</option>
                                @foreach ($activityTypes as $type)
                                    <option value="{{ $type->activity_type }}"
                                        {{ request('activity_type') == $type->activity_type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type->activity_type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="ip_address" class="form-control"
                                value="{{ request('ip_address') }}" placeholder="IP Address">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"
                                placeholder="From Date">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"
                                placeholder="To Date">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('user-activity.ip-tracking') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Activities Table -->
            <div class="card table_sec">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Activity</th>
                                <th>Description</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Browser</th>
                                <th>Platform</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td>
                                        {{ $activity->user->name }}<br>
                                        <small class="text-muted">{{ $activity->user->email }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</span>
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity->ip_address }}</td>
                                    <td>{{ $activity->device_type }}</td>
                                    <td>{{ $activity->browser }}</td>
                                    <td>{{ $activity->platform }}</td>
                                    <td>{{ $activity->activity_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No activities found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            </div>

            <div class="row mt-4">
                <!-- Top IPs -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Top IP Addresses</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>IP Address</th>
                                            <th>Activities</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topIPs as $ip)
                                            <tr>
                                                <td>{{ $ip->ip_address }}</td>
                                                <td>{{ $ip->activity_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Types -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Activity Types Breakdown</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Activity Type</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activityTypes as $type)
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $type->activity_type)) }}</td>
                                                <td>{{ $type->count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
