@extends('admin.layouts.master')
@section('title')
    Dashboard - {{ env('APP_NAME') }} admin
@endsection
@push('styles')
@endpush
@section('head')
    Dashboard
@endsection
@section('content')
    <div class="main-content" style="min-height: 842px;">

        <div class="dashboard_tab pt-5 pl-0 pb-5 pl-sm-5">
            <!-- Nav tabs -->

            <div class="">

                <div class="left_right">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <h2 class="flight_titel">Flight</h2> -->
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="mini_box small_bg_1">
                                        <h3>{{ 0 }}</h3>
                                        <p>Total -</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="mini_box small_bg_2">
                                        <h3>{{ 0 }}</h3>
                                        <p>Total -</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="mini_box small_bg_3">
                                        <h3>{{ 0 }}</h3>
                                        <p>Total -</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="mini_box small_bg_4">
                                        <h3>{{ 0 }}</h3>
                                        <p>Total -</p>
                                    </div>
                                </div>



                            </div>
                            <div class="booking_by_sorce">
                                <div class="row">

                                    

                                    <div class="col-md-12">
                                        <div class="card p-3 agent_list min_height355 box_shadow">
                                            <div class="mb-2">
                                                <h5 class="mb-3">Recent Login Sessions</h5>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>User</th>
                                                                <th>IP Address</th>
                                                                <th>Login Time</th>
                                                                <th>Logout Time</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($loginSessions as $session)
                                                                <tr>
                                                                    <td>{{ $session->user->name ?? 'Unknown' }} <br><small
                                                                            class="text-muted">{{ $session->user->email ?? '' }}</small>
                                                                    </td>
                                                                    <td>{{ $session->ip_address }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($session->login_at)->format('d M Y, h:i A') }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($session->logout_at)
                                                                            {{ \Carbon\Carbon::parse($session->logout_at)->format('d M Y, h:i A') }}
                                                                        @else
                                                                            <span class="text-muted">Still active /
                                                                                expired</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($session->logout_at)
                                                                            <span class="badge bg-danger">Logged Out</span>
                                                                        @else
                                                                            <span class="badge bg-success">Active</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">No login sessions
                                                                        found.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                {{ $loginSessions->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div>
@endsection

@push('scripts')
@endpush
