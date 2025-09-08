<div class="main-sidebar sidebar-style-2" tabindex="1">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            {{-- <a href="{{ route('admin.dashboard') }}"><span class="logo-name"><img
                        src="{{ asset('admin_assets/img/logo.png') }}" /></span> </a>
            <a href="{{ route('admin.dashboard') }}"><span class="logo-fm "><img class="mb-2"
                        src="{{ asset('admin_assets/img/logo_fm.png') }}" /></span> </a> --}}
                        <h3 class="mt-2 text-white">{{env('APP_NAME')}}</h3>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0);"
                    class="menu-toggle nav-link has-dropdown {{ Request::is('admin/profile*') || Request::is('admin/password*') || Request::is('admin/detail*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>Manage Account</span>
                </a>
                <ul class="dropdown-menu"
                    style="{{ Request::is('admin/profile*') || Request::is('admin/password*') || Request::is('admin/detail*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ Request::is('admin/profile*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('admin.profile') }}"><i class="fas fa-user"></i> My Profile</a></li>
                    <li class="{{ Request::is('admin/password*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('admin.password') }}"><i class="fas fa-lock"></i> Change Password</a></li>
                </ul>
            </li>

            @can('view-roles')
                <li class="dropdown">
                    <a href="javascript:void(0);"
                        class="menu-toggle nav-link has-dropdown {{ Request::is('admin/roles*') || Request::is('admin/admin*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin Users Management</span>
                    </a>
                    <ul class="dropdown-menu"
                        style="{{ Request::is('admin/roles*') || Request::is('admin/admin*') ? 'display: block;' : 'display: none;' }}">
                        @can('view-roles')
                            <li class="{{ Request::is('admin/roles') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('roles.index') }}"><i class="fas fa-shield-alt"></i> Manage Roles</a></li>
                        @endcan
                        @can('view-admins')
                            <li class="{{ Request::is('admin/admin') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.index') }}"><i class="fas fa-users-cog"></i> Manage Admins</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('view-customers')
                <li class="dropdown">
                    <a href="javascript:void(0);"
                        class="menu-toggle nav-link has-dropdown {{ Request::is('admin/customers*') ? 'active' : ' ' }}">
                        <i class="fas fa-users"></i>
                        <span>Customers Management</span>
                    </a>
                    <ul class="dropdown-menu"
                        style="{{ Request::is('admin/customers*') ? 'display: block;' : 'display: none;' }}">
                        @can('create-customers')
                            <li class="{{ Request::is('admin/customers/create') ? 'active' : ' ' }}"><a class="nav-link"
                                    href="{{ route('customers.create') }}">Create Customers</a></li>
                        @endcan
                        <li class="{{ Request::is('admin/customers') ? 'active' : ' ' }}"><a class="nav-link"
                                href="{{ route('customers.index') }}"> Customers List</a></li>

                    </ul>
                </li>
            @endcan



            <li class="menu-header">User Activity</li>
            <li class="dropdown">
                <a href="javascript:void(0);"
                    class="menu-toggle nav-link has-dropdown {{ Request::is('admin/user-activity*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>User Activity Monitoring</span>
                </a>
                <ul class="dropdown-menu"
                    style="{{ Request::is('admin/user-activity*') ? 'display: block;' : 'display: none;' }}">

                    <li class="{{ Request::is('admin/user-activity/ip-tracking*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user-activity.ip-tracking') }}">
                            <i class="fas fa-map-marker-alt"></i> IP Address Tracking
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Others</li>














        </ul>
    </aside>
</div>
