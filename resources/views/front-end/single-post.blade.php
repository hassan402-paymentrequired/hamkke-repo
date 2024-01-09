@extends('layouts.frontend.front-app', ['pageTitle' => $post->title])

@section('content')
    <div class="section">
        <div class="container">
            <div class="sticky-top article-top-bg">
                <button type="button" id="back-button" data-href="{{ url()->previous() }}"> Back </button>
                <h4>{{ $post->title }}</h4>
            </div>
            <div class="article-div" id="postContent">

            </div>
        </div>
    </div>
@endsection

@section('more-scripts')
    <script>
        (function ($) {
            const postContent = @json($post->body);
            HamkkeJsHelpers.convertQuillDeltaToHTML('#postContent', postContent);
            $('#back-button').on('click', function (e){
                location.href=$(e.target).data('href');
            });
        })(jQuery);
    </script>
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
