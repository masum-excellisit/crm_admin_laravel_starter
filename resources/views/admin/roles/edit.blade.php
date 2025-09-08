@extends('admin.layouts.master')
@section('title', 'Edit Role')

@section('content')
    <div class="main-content">
        <div class="inner_page">
            <div class="card search_bar sales-report-card">
                <div class="sales-report-header">
                    <h2>Edit Role: {{ $role->name }}</h2>
                    <div class="btn-1 btn btn-primary mb-2">
                        <a class="text-white" href="{{ route('roles.index') }}">Back to Roles</a>
                    </div>
                </div>

                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $role->name) }}" required>
                                @if ($errors->has('name'))
                                    <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h4>Permissions</h4>
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="permission-group mb-3">
                                    <h5>{{ ucfirst($group) }} Management</h5>
                                    <div class="row">
                                        @foreach ($groupPermissions as $permission)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission_{{ $permission->id }}"
                                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @if ($errors->has('permissions'))
                                <div class="error" style="color:red;">{{ $errors->first('permissions') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
