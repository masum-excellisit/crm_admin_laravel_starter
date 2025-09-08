@extends('admin.layouts.master')
@section('title')
    Video Watches - {{ env('APP_NAME') }}
@endsection

@section('head')
    Video Watch History
@endsection

@section('content')
    <div class="main-content">
        <div class="inner_page">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_1">
                        <h3>{{ number_format($stats['total_watches']) }}</h3>
                        <p>Total Watches</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_2">
                        <h3>{{ $stats['unique_users'] }}</h3>
                        <p>Unique Users</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_3">
                        <h3>{{ gmdate('H:i:s', $stats['total_watch_time']) }}</h3>
                        <p>Total Watch Time</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mini_box small_bg_4">
                        <h3>{{ round($stats['avg_completion'], 1) }}%</h3>
                        <p>Avg Completion</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <select name="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
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
                            <a href="{{ route('user-activity.video-watches') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Video Watches Table -->
            <div class="card table_sec">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Course</th>
                                <th>Video Name</th>
                                <th>Watch Duration</th>
                                <th>Completion</th>
                                <th>IP Address</th>
                                <th>Started At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($watches as $watch)
                                <tr>
                                    <td>
                                        {{ $watch->user->name }}<br>
                                        <small class="text-muted">{{ $watch->user->email }}</small>
                                    </td>
                                    <td>{{ $watch->course->name }}</td>
                                    <td>{{ $watch->video_name }}</td>
                                    <td>{{ $watch->formatted_watch_duration }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $watch->completion_percentage }}%">
                                                {{ round($watch->completion_percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $watch->ip_address }}</td>
                                    <td>{{ $watch->started_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No video watches found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $watches->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- Top Watchers -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Top Video Watchers</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Watch Count</th>
                                    <th>Total Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topWatchers as $watcher)
                                    <tr>
                                        <td>{{ $watcher->user->name }}</td>
                                        <td>{{ $watcher->watch_count }}</td>
                                        <td>{{ gmdate('H:i:s', $watcher->total_time) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
