@extends('layouts.app', ['pageTitle' => 'Forum Threads::List'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Forum Threads /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">
                @include('components.posts.post-statuses-nav-tabs')
            </h5>
            <div class="card-body">
                @include('components.forum.forum-posts-table', compact('forumPosts'))
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection

@section('more-scripts')
    <script>
        function deleteForumPost(url) {
            HamkkeJsHelpers.submitActionForm(url, 'This thread will not longer be accessible')
        }
    </script>
    <script src="{{ asset('cms-assets/js/pages/create-post.js') }}"></script>
@endsection
