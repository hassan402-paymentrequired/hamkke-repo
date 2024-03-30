@extends('layouts.app', ['pageTitle' => 'Post::List'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Posts /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header">
                @include('components.posts.post-statuses-nav-tabs')
            </div>
            {{--            <h5 class="card-header">Posts</h5>--}}
            <div class="card-body">
                @include('components.posts-table', compact('posts'))
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection

@section('more-scripts')
    <script src="{{ assetWithVersion('cms-assets/js/pages/create-post.js') }}"></script>
@endsection
