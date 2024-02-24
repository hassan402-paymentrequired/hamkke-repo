@extends('layouts.app', ['pageTitle' => 'Forum Discussion'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Forum Discussions /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header">
                @include('components.posts.post-statuses-nav-tabs')
            </div>
            {{--            <h5 class="card-header">Posts</h5>--}}
            <div class="card-body">
                @include('components.forum.forum-discussions-table', compact('forumDiscussions'))
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection

@section('more-scripts')
    <script src="{{ asset('cms-assets/js/pages/create-post.js') }}"></script>
@endsection
