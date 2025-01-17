@extends('layouts.app', ['pageTitle' => 'User::List'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Users /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Users</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <caption>All Users</caption>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name|Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td><img src="{{ $user->avatar }}" alt="User Avatar" height="40px"></td>
                                <td>{{ $user->name }}@if($user->username)
                                        {{ " | @$user->username" }}
                                    @endif</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleData()->display_name }}</td>
                                <td class="{{ $user->is_active ?'text-success' : 'text-danger' }}">
                                    {{ $user->is_active ? 'ACTIVE' : 'DEACTIVATED' }}
                                </td>
                                <td>
                                    @if($authUser->canUpdateUser($user))
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if($authUser->can('admin.user.update'))
                                                <a class="dropdown-item text-primary"
                                                   href="{{ route('admin.user.update', $user) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                                @endif
                                                @if($authUser->id !== $user->id)
                                                    @if($user->is_active)
                                                        <a class="dropdown-item text-warning"
                                                           onclick="HamkkeJsHelpers.submitActionForm(
                                                           '{{ route('admin.user.deactivate', $user) }}',
                                                           'This user will no longer have access to the application'
                                                       )"
                                                           href="javascript:void(0);">
                                                            <i class="ti ti-pencil me-1"></i> Deactivate
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item text-success"
                                                           onclick="HamkkeJsHelpers.submitActionForm(
                                                           '{{ route('admin.user.activate', $user) }}',
                                                           'This user\'s access to the application will be restored'
                                                       )"
                                                           href="javascript:void(0);">
                                                            <i class="ti ti-pencil me-1"></i> Activate
                                                        </a>
                                                    @endif
                                                    @if($authUser->can('admin.user.delete'))
                                                        <a class="dropdown-item text-danger"
                                                           onclick="HamkkeJsHelpers.submitActionForm(
                                                           '{{ route('admin.user.delete', $user) }}',
                                                           'This user will be removed from the application'
                                                       )"
                                                           href="javascript:void(0);">
                                                            <i class="ti ti-trash me-1"></i> Delete
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        --
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Users Found..</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
