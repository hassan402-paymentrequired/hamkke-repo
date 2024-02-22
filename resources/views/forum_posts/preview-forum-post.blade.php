@php use App\Helpers\PostParser; @endphp
<?php
/**
 * @var \App\Models\ForumPost $forumPost
 * @var \App\Models\ForumDiscussion $discussion
 */
?>
@extends('layouts.frontend.front-app', ['pageTitle' => "Preview Thread :: {$forumPost->topic}"])

@section('content')

    <section class="section category-posts-div forum-div">
        <div class="container">
            <div class="row marginX">
                <div class="nav col-md-3 paddingR nav-pills sticky-top" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <span class="sticky-top">
                        @include('components.front.start-thread-button')
                        @if ($forumPost->user_id)
                            <h5 class="bg-black text-white p-2" style="border-radius: 5px">Author</h5>
                        @endif
                        <div class="d-flex profile-div align-items-center">
                            <img src="{{ getCorrectAbsolutePath($postAuthor->avatar) }}" class="profile-img" alt="profile">
                            <span>{{ $postAuthor->name }}</span>
                        </div>
                        <p>{{ $postAuthor->author_bio }}</p>
                    </span>
                </div>

                <div class="col-md-9 paddingR tab-content pt-0" id="v-pills-tabContent">
                    <div class="article-top-bg">
                        <div class="article-top-bg">
                            <button type="button" id="back-button">
                                <a href="{{ route('forum.posts') }}" class="text-hamkke-purple">
                                    <em class="fa fa-arrow-left-long"></em>
                                    <span class="ml-1">Back To Forum</span>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="article-div">
                        <div class="row">
                            <div class="d-flex profile-div align-items-center mt-0">
                                <img src="{{ asset($postAuthor->avatar) }}" alt="profile">
                                <span>{{ $postAuthor->name }}</span>
                            </div>

                        </div>
                        <h5 class="card-title">{{ $forumPost->topic }}</h5>
                        <p class="card-text">{!! $parsedPostBody !!}</p>

                        <div class="like-div">
                            {{-- TODO:: Allow logged-in customers like the post and clicking again should remove the like :) --}}
                            <span>
                                0
                                <a href="javascript:void(0);" class="text-decoration-none" id="like-button"
                                   data-post-id="{{ $forumPost->slug }}">
                                    <img src="{{ asset('frontend-assets/likes.png') }}" alt="..." />
                                </a>
                                <span class="text">Likes</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('more-scripts')
    <script src="{{ assetWithVersion('frontend-assets/pages/forum-posts.js') }}"></script>
@stop
