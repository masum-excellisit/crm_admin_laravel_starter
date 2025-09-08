@extends('admin.layouts.master')
@section('title', 'Admin Management')

@section('content')
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-header">
                    <h2>Admin Management</h2>
                    @can('create-admins')
                        <div class="btn-1">
                            <a href="javascript:void(0);" id="add-admin-modal" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#addAdminModal">Add New Admin</a>
                        </div>
                    @endcan
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($admin->profile_picture)
                                            <img src="{{ Storage::url($admin->profile_picture) }}" alt="Profile"
                                                style="width: 40px; height: 40px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('admin_assets/img/profile_dummy.png') }}" alt="Profile"
                                                style="width: 40px; height: 40px; border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach ($admin->roles as $role)
                                            <span class="badge bg-primary text-white">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge {{ $admin->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $admin->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @can('edit-admins')
                                            <button class="btn btn-sm btn-primary edit-admin"
                                                data-id="{{ $admin->id }}">Edit</button>
                                        @endcan
                                        @can('delete-admins')
                                            @if (!($admin->hasRole('ADMIN') && \App\Models\User::role('ADMIN')->count() <= 1))
                                                <a href="{{ route('admin.delete', $admin->id) }}" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</a>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Admin Modal -->
    {{-- @can('create-admins') --}}
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Admin</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required autocomplete="new-password">
                        </div>
                        <div class="form-group mb-3">
                            <label>Role</label>
                            <select class="form-control" name="role" required>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Profile Picture</label>
                            <input type="file" class="form-control" name="profile_picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- @endcan --}}

    <!-- Edit Admin Modal -->
    @can('edit-admins')
        <div class="modal fade" id="editAdminModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Admin</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_admin_id">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" name="edit_name" id="edit_name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="edit_email" id="edit_email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Role</label>
                                <select class="form-control" name="role" id="edit_role" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Profile Picture</label>
                                <input type="file" class="form-control" name="profile_picture">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.edit-admin').on('click', function() {
                var adminId = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.edit', ':id') }}'.replace(':id', adminId),
                    type: 'GET',
                    success: function(response) {
                        $('#edit_admin_id').val(response.admin.id);
                        $('#edit_name').val(response.admin.name);
                        $('#edit_email').val(response.admin.email);

                        // Set the role dropdown
                        if (response.admin.roles && response.admin.roles.length > 0) {
                            $('#edit_role').val(response.admin.roles[0].name);
                        }

                        $('#editAdminModal').modal('show');
                    },
                    error: function() {
                        alert('Error loading admin data');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#add-admin-modal').click(function() {
                $('#addAdminModal').modal('show');
            });
        });
    </script>
@endpush
