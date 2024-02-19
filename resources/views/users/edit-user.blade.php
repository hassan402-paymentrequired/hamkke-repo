@extends('layouts.app', ['pageTitle' => 'Edit User'])

@section('main-content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Users /{{ $user->username ?: $user->id }}/</span> Edit
    </h4>

    <div class="row">
        <form id="userUpdateForm" action="{{ route('admin.user.update', compact('user')) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <!-- Full Editor -->
            <div class="col-12">
                <div class="card mb-4">
                    <h5 class="card-header">Update User</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
                            <img src="{{ $user->avatar }}" alt="User Avatar"
                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedUserAvatar"/>
                            <div class="button-wrapper">
                                <label for="userAvatar" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Click to Upload User Avatar</span>
                                    <em class="ti ti-upload d-block d-sm-none"></em>
                                    <input type="file" id="userAvatar" hidden
                                           accept="image/png, image/jpeg" name="user_avatar"/>
                                </label>
                                <button type="button" id="resetAvatarField" class="btn btn-label-secondary mb-3">
                                    <em class="ti ti-refresh-dot d-block./.. d-sm-none"></em>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>
                                <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                            </div>
                            @form_field_error('user_avatar')
                        </div>
                        <hr class="my-0"/>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ old('name', $user->name) }}" id="fullName"
                                   name="name" required placeholder="Display Name"/>
                            @form_field_error('name')
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" value="{{ old('email', $user->email) }}"
                                   id="userEmail" name="email" required placeholder="johndoe@example.com"/>
                            @form_field_error('email')
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                Username
                            </label>
                            <input type="text" class="form-control" value="{{ old('username', $user->username) }}"
                                   id="username" name="text" placeholder="unique username"/>
                            @form_field_error('username')
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role<span class="text-danger">*</span></label>
                            <select class="form-select" id="userRole" name="role" aria-label="Role Selection" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            @form_field_error('role')
                        </div>
                        <div class="mb-3">
                            <label for="authorBio" class="form-label">About the author</label>
                            <textarea class="form-control" id="authorBio" name="author_bio"
                                      rows="4">{{ old('author_bio', $user->author_bio) }}</textarea>
                            @form_field_error('author_bio')
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-outline-primary me-2">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Full Editor -->
        </form>
    </div>
@endsection

@section('more-scripts')
    <script src="{{ asset("cms-assets/js/pages/create-update-user.js") }}"></script>
@endsection
