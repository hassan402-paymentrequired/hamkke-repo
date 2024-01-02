@extends('layouts.app', ['pageTitle' => 'Post::List'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Posts /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Posts</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <caption>Created Posts</caption>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->post_category }}</td>
                                    <td>{{ $post->post_status_id->name }}</td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.post.update', $post) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item"
                                                    onclick="deletePost('{{ route('admin.post.delete', $post) }}')"
                                                    href="javascript:void(0);">
                                                    <i class="ti ti-trash me-1"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Posts Found..</td>
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

@section('more-scripts')
    <script>
        function deletePost($url) {
            HamkkeJsHelpers.confirmationAlert('This post will not longer be accessible', 'Are you sure?')
                .then(continueAction => {
                    $('#postDeleteForm').submit();
                });
        }
    </script>
    <script src="{{ asset('cms-assets/js/pages/create-post.js') }}"></script>
@endsection
