@extends('layouts.app', ['pageTitle' => 'Post::List'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Posts /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Posts</h5>
            <div class="card-body">
                @include('components.posts-table', compact('posts'))
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
