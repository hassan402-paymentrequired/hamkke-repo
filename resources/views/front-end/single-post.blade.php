@extends('layouts.frontend.front-app', ['pageTitle' => $post->title])

@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top">
                        <h5 class="bg-black text-white p-2" style="border-radius: 5px;">Author</h5>
                        <div class="d-flex profile-div align-items-center">
                            <img src="{{ getCorrectAbsolutePath($postAuthor->avatar) }}" class="profile-img" alt="profile">
                            <span>{{ $postAuthor->name }}</span>
                        </div>
                        <p>{{ $postAuthor->author_bio }}</p>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="sticky-top article-top-bg">
                        <button type="button" id="back-button" data-href="{{ url()->previous() }}"> Back</button>
                    </div>

                    <div class="article-div">
                        <img class="card-img-top stick" src="{{ getCorrectAbsolutePath($post->featured_image) }}"
                             alt="{{ $post->title }} - featured image"/>

                        <h4>{{ $post->title }}</h4>
                        <div id="postContent">

                        </div>


                        <div class="like-div">
                            {{-- TODO:: Allow logged-in customers like the post and clicking again should remove the like :) --}}
                            <span>
                                {{ $post->likes()->count() }}
                                <img src="{{ asset('frontend-assets/likes.png') }}" alt="..."/>
                                <span class="text">Likes</span>
                            </span>
                        </div>


                        <div class="row">
                            <div class="col-12 dropdown">

                                <span class="post-comment-button">
                                    {{ $postComments->count() }}
                                    <img src="{{ asset('frontend-assets/comment.png') }}" alt="..."/>
                                    <span class="text">Comments</span>
                                </span>

                                <div class="post-comment-content">
                                    <div class="comment">
                                        <div class="searchbox">
                                            {{-- TODO:: Check if the customer is logged-in before showing the comment for
                                            {{-- TODO:: Allow logged-in customers send in their comment --}}
                                            <p class="card-text">Leave a Comment</p>
                                            <input name="comment" type="search" placeholder="type something"/>
                                        </div>

                                        <div class="title">Comments</div>
                                        @foreach($postComments as $postComment)
                                            <div class="comment-section @if(!$loop->first()) top-line @endif">
                                                <span>{{ $postComment->customer_name }}</span>
                                                <p class="card-text">{{ $postComment->body }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="related-div">

                        <h4>Related Posts</h4>

                        <div class="d-flex flex-row flex-wrap forum-row justify-content-between">
                            @foreach ($relatedPosts as $post)
                                <div class="col-md-4">
                                    <div class="card-box">
                                        <div class="overlay">
                                            <p><a href="{{ route('post.view', $post) }}"> {{ $post->title }}</a></p>
                                        </div>
                                        <img src="{{ getCorrectAbsolutePath($post->featured_image) }}"
                                             alt="Featured Image - {{ $post->title }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    `
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
            const articleText = document.getElementById("postContent").innerText;
            console.log({articleText});
            const estimatedReadingTime = HamkkeJsHelpers.readingTime(articleText);
            console.log({estimatedReadingTime});
            $('#back-button').on('click', function (e) {
                location.href = $(e.target).data('href');
            });
        })(jQuery);
    </script>
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
