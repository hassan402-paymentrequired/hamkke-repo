@extends('layouts.frontend.front-app', ['pageTitle' => $post->title])

@section('main-content')
    <div class="section">
        <div class="container">
            <div class="sticky-top article-top-bg">
                <a href="{{ url()->previous() }}"> Back </a>
                <h4>{{ $post->title }}</h4>
            </div>
            <div class="article-div" id="postContent">

            </div>
        </div>
    </div>
@endsection

@section('more_scripts')
    <script>
        HamkkeJsHelpers.convertQuillDeltaToHTML('#postContent', "{{ $post->body }}");
    </script>
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
