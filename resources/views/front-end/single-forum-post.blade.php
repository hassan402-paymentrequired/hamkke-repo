<?php
/**
 * @var \App\Models\ForumPost $forumPost
 * @var \App\Models\ForumDiscussion $discussion
 */
?>
@extends('layouts.frontend.front-app', ['pageTitle' => $forumPost->topic])

@section('content')

    <section class="section category-posts-div forum-div">
        <div class="container">
            <div class="row marginX">
                <div class="nav col-md-3 paddingR nav-pills sticky-top" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <span class="sticky-top">
                        <button class="post-btn" type="button" data-bs-toggle="modal" data-bs-target="#postDiscussionModal">Start Discussion</button>
                        <h5 class="bg-black text-white p-2" style="border-radius: 5px">Author</h5>
                        <div class="d-flex profile-div align-items-center">
                            <img src="{{ getCorrectAbsolutePath($postAuthor->avatar) }}" class="profile-img"
                                 alt="profile">
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
                                    <img src="{{ asset('frontend-assets/likes.png') }}" alt="..."/>
                                </a>
                                <span class="text">Likes</span>
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <span class="post-comment-button">
                                    {{ $discussions->count() }}
                                    <img src="{{ asset('frontend-assets/comment.png') }}" alt="..."/>
                                    <span class="text">Comments</span>
                                </span>

{{--                                <div class="post-comment-content">--}}
{{--                                    <div class="comment">--}}
{{--                                        <div class="comment-form">--}}
{{--                                            <label class="card-text" for="comment-textarea">Leave a Comment</label>--}}
{{--                                            <textarea name="comment" @if(old('comment')) autofocus @endif type="search"--}}
{{--                                                      id="comment-textarea"--}}
{{--                                                      placeholder="Write a comment{{ customerIsLoggedIn() ? " as {$customerAuthUser->username}": '' }}">{{ old('comment') }}</textarea>--}}
{{--                                            @if(!customerIsLoggedIn())--}}
{{--                                                <div class="card" id="customerAuthForm">--}}
{{--                                                    <hr>--}}
{{--                                                    <p class="card-text">--}}
{{--                                                        Log in to leave a reply. <br>--}}
{{--                                                        <small class="text-hamkke-purple">--}}
{{--                                                            New here?--}}
{{--                                                            <a href="javascript:void(0);" id="commentRegisterLink">--}}
{{--                                                                Register--}}
{{--                                                            </a>--}}
{{--                                                        </small>--}}
{{--                                                    </p>--}}
{{--                                                    <ul class="nav nav-tabs" id="authTab" role="tablist">--}}
{{--                                                        <li class="nav-item" role="presentation">--}}
{{--                                                            <button class="nav-link active" id="login-tab"--}}
{{--                                                                    data-bs-toggle="tab" data-bs-target="#login"--}}
{{--                                                                    type="button" role="tab" aria-controls="home"--}}
{{--                                                                    aria-selected="true">Login--}}
{{--                                                            </button>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="nav-item" role="presentation">--}}
{{--                                                            <button class="nav-link" id="register-tab"--}}
{{--                                                                    data-bs-toggle="tab" data-bs-target="#register"--}}
{{--                                                                    type="button" role="tab" aria-controls="profile"--}}
{{--                                                                    aria-selected="false">Register--}}
{{--                                                            </button>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                    <div class="tab-content pt-2" id="authTabContent">--}}
{{--                                                        <div class="tab-pane fade show active" id="login"--}}
{{--                                                             role="tabpanel" aria-labelledby="home-tab">--}}
{{--                                                            <form method="POST" id="customer-login"--}}
{{--                                                                  action="{{ route('post.comment.add', $post) }}"--}}
{{--                                                                  enctype="multipart/form-data">--}}
{{--                                                                @csrf--}}
{{--                                                                <input name="login_request" value="yes" type="hidden">--}}
{{--                                                                <input type="email" name="email"--}}
{{--                                                                       class="customer-login-input"--}}
{{--                                                                       placeholder="Email * (Address never made public)"--}}
{{--                                                                       value="{{ old('email') }}">--}}
{{--                                                                <input type="password" name="password"--}}
{{--                                                                       class="customer-login-input"--}}
{{--                                                                       placeholder="Enter Password *">--}}
{{--                                                                <div class="form-check form-switch">--}}
{{--                                                                    <input class="form-check-input customer-login-input"--}}
{{--                                                                           checked--}}
{{--                                                                           type="checkbox" name="remember_me"--}}
{{--                                                                           role="switch" id="subscription-checkbox">--}}
{{--                                                                    <label class="form-check-label"--}}
{{--                                                                           for="subscription-checkbox">Remember me on--}}
{{--                                                                        this browser for the next time I comment</label>--}}
{{--                                                                </div>--}}
{{--                                                                <hr>--}}
{{--                                                                <button--}}
{{--                                                                    class="btn btn-primary pull-right customer-login-input--}}
{{--                                                                        comment-submit-btn"--}}
{{--                                                                    disabled type="submit" data-form-id="customer-login"--}}
{{--                                                                    data-form-action="{{ route('post.comment.add', $post) }}">--}}
{{--                                                                    Submit--}}
{{--                                                                </button>--}}
{{--                                                            </form>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="tab-pane fade" id="register" role="tabpanel"--}}
{{--                                                             aria-labelledby="profile-tab">--}}
{{--                                                            <form method="POST" id="customer-register"--}}
{{--                                                                  action="{{ route('post.comment.add', $post) }}"--}}
{{--                                                                  enctype="multipart/form-data"--}}
{{--                                                                  oninput='register_password_confirmation.setCustomValidity(register_password_confirmation.value !== register_password.value--}}
{{--                                                                    ? "Passwords do not match." : "")'>--}}
{{--                                                                @csrf--}}
{{--                                                                <input name="registration_request" value="yes"--}}
{{--                                                                       type="hidden">--}}
{{--                                                                <input type="email" class="customer-register-input"--}}
{{--                                                                       name="email"--}}
{{--                                                                       placeholder="Email * (Address never made public)"--}}
{{--                                                                       value="{{ old('email') }}">--}}
{{--                                                                <input type="text" class="customer-register-input"--}}
{{--                                                                       name="username"--}}
{{--                                                                       placeholder="Username"--}}
{{--                                                                       value="{{ old('username') }}">--}}
{{--                                                                <input type="password" class="customer-register-input"--}}
{{--                                                                       name="register_password"--}}
{{--                                                                       placeholder="Enter Password *">--}}
{{--                                                                <input type="password" class="customer-register-input"--}}
{{--                                                                       name="register_password_confirmation"--}}
{{--                                                                       placeholder="Confirm Password">--}}
{{--                                                                <div class="form-check form-switch">--}}
{{--                                                                    <input--}}
{{--                                                                        class="form-check-input customer-register-input"--}}
{{--                                                                        checked type="checkbox" name="subscribe"--}}
{{--                                                                        role="switch" id="subscription-checkbox">--}}
{{--                                                                    <label class="form-check-label"--}}
{{--                                                                           for="subscription-checkbox">Don’t miss out on--}}
{{--                                                                        all the special stuff! Join the Hamkke--}}
{{--                                                                        Club</label>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="form-check form-switch">--}}
{{--                                                                    <input--}}
{{--                                                                        class="form-check-input customer-register-input"--}}
{{--                                                                        checked--}}
{{--                                                                        type="checkbox" name="remember_me"--}}
{{--                                                                        role="switch" id="subscription-checkbox">--}}
{{--                                                                    <label class="form-check-label"--}}
{{--                                                                           for="subscription-checkbox">Remember me on--}}
{{--                                                                        this browser for the next time I comment</label>--}}
{{--                                                                </div>--}}
{{--                                                                <hr>--}}
{{--                                                                <button--}}
{{--                                                                    class="btn btn-primary pull-right customer-register-input--}}
{{--                                                                        comment-submit-btn" disabled--}}
{{--                                                                    type="button" data-form-id="customer-register"--}}
{{--                                                                    data-form-action="{{ route('post.comment.add', $post) }}">--}}
{{--                                                                    Submit--}}
{{--                                                                </button>--}}
{{--                                                            </form>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @else--}}
{{--                                                <hr>--}}
{{--                                                <button class="btn btn-primary pull-right comment-submit-btn" disabled--}}
{{--                                                        type="button"--}}
{{--                                                        data-form-action="{{ route('post.comment.add', $post) }}"--}}
{{--                                                        id="submit-comment">Submit--}}
{{--                                                </button>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}

{{--                                        <div class="title">Comments</div>--}}
{{--                                        @foreach($discussions as $discussion)--}}
{{--                                            <div class="comment-section @if(!$loop->first) top-line @endif">--}}
{{--                                                <span--}}
{{--                                                    class="font-bold">{{ $discussion->g ?: $postComment->username }}</span>--}}
{{--                                                <p class="card-text">{{ $postComment->body }}</p>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>


                @include('components.front.start-discussion-modal')
            </div>
        </div>
    </section>

@endsection

@section('more-scripts')
    <script src="{{ asset('frontend-assets/pages/single-forum-post.js') }}"></script>
@stop
