@extends('layouts.frontend.front-app', ['pageTitle' => $post->title])

@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="sticky-top article-top-bg">
                        <button type="button" id="back-button" data-href="{{ url()->previous() }}"> Back</button>
                        <h4>{{ $post->title }}</h4>
                    </div>
                    <div class="article-div">
                        <div id="postContent">

                        </div>
                        <!-- Like Button -->
                        <button id="likeButton">Like</button>

                        <!-- Sharing Options -->
                        <div>
                            <h4>Share this article:</h4>
                            <!-- Facebook Share Button -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                               target="_blank">
                                <img src="{{ asset('frontend-assets/facebook.png') }}" alt="Facebook Share">
                            </a>

                            <!-- Twitter Share Button -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}"
                               target="_blank">
                                <img src="{{ asset('frontend-assets/twitter.png') }}" alt="Twitter Share">
                            </a>
                        </div>
                        <!-- Comment Section -->
                        <div>
                            <h2 class="mb-3">Comments</h2>
                            <!-- Display existing comments -->
                            @forelse($post->comments as $comment)
                                <div class="mb-3 p-2 border">
                                    <strong>{{ $comment->customer->name }}</strong>: {{ $comment->body }}
                                </div>
                            @empty
                                <p>No comments yet. Be the first to comment!</p>
                            @endforelse

                            <!-- Add new comment form -->
                            <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="post">
                                @csrf
                                <textarea name="content" placeholder="Add a comment"></textarea>
                                <button type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('more-scripts')
    <script>
        (function ($) {
            const postContent = @json($post->body);
            HamkkeJsHelpers.convertQuillDeltaToHTML('#postContent', postContent);
            $('#back-button').on('click', function (e) {
                location.href = $(e.target).data('href');
            });
        })(jQuery);
    </script>
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
