@extends('admin.layouts.master')
@section('title', 'Role Management')

@section('content')
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-header">
                    <h2>Role Management</h2>
                    @can('create-roles')
                        <div class="btn-1">
                            <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">Add New Role</a>
                        </div>
                    @endcan
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions Count</th>
                                <th>Users Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->permissions->count() }}</td>
                                    <td>{{ $role->users->count() }}</td>
                                    <td>
                                        @can('edit-roles')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @endcan
                                        @can('delete-roles')
                                            @if (!in_array($role->name, ['ADMIN']))
                                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
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
@endsection
