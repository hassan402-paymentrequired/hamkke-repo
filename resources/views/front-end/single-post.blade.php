@extends('layouts.frontend.front-app', ['pageTitle' => $post->title])

@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top">
                        <h5 class="bg-black text-white p-2" style="border-radius: 5px;">Author</h5>
                        <div class="d-flex profile-div align-items-center">
                            <img src="{{ getCorrectAbsolutePath($postAuthor->avatar) }}" class="profile-img"
                                 alt="profile">
                            <span>{{ $postAuthor->name }}</span>
                        </div>
                        <p>{{ $postAuthor->author_bio }}</p>
                        <hr>
                        @component('components.front.ads-component-portrait')
                        @endcomponent
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
                        {{--                        <span class="card-text">--}}
                        {{--                            {{ calculateReadingTime($parsedPostBody) }} read--}}
                        {{--                        </span>--}}
                        <div id="postContent">{!! $parsedPostBody !!}</div>

                        <div class="like-div">
                            <livewire:customer-front.post-like-button :post="$post"/>
{{--                            <span class="post-comment-button">--}}
{{--                                {{ $postComments->count() }}--}}
{{--                                <img src="{{ asset('frontend-assets/comment.png') }}" alt="..."/>--}}
{{--                                <span class="text">Comments</span>--}}
{{--                            </span>--}}
                        </div>


                        <div class="row">
                            <div class="col-12 dropdown">
                                <div class="post-comment-content">
                                    <div class="comment">
                                        <div class="comment-form">
                                            <label class="card-text" for="comment-textarea">Leave a Comment</label>
                                            <textarea name="comment" @if(old('comment')) autofocus @endif type="search"
                                                      id="comment-textarea"
                                                      placeholder="Write a comment{{ customerIsLoggedIn() ? " as {$customerAuthUser->username}": '' }}">{{ old('comment') }}</textarea>
                                            @if(!customerIsLoggedIn())
                                                <div class="card" id="customerAuthForm">
                                                    <hr>
                                                    <p class="card-text">
                                                        Log in to leave a reply. <br>
                                                        <small class="text-hamkke-purple">
                                                            New here?
                                                            <a href="javascript:void(0);" id="commentRegisterLink">
                                                                Register
                                                            </a>
                                                        </small>
                                                    </p>
                                                    <ul class="nav nav-tabs" id="authTab" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="login-tab"
                                                                    data-bs-toggle="tab" data-bs-target="#login"
                                                                    type="button" role="tab" aria-controls="home"
                                                                    aria-selected="true">Login
                                                            </button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="register-tab"
                                                                    data-bs-toggle="tab" data-bs-target="#register"
                                                                    type="button" role="tab" aria-controls="profile"
                                                                    aria-selected="false">Register
                                                            </button>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content pt-2" id="authTabContent">
                                                        <div class="tab-pane fade show active" id="login"
                                                             role="tabpanel" aria-labelledby="home-tab">
                                                            <form method="POST" id="customer-login"
                                                                  action="{{ route('post.comment.add', $post) }}"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input name="login_request" value="yes" type="hidden">
                                                                <input type="email" name="email"
                                                                       class="customer-login-input"
                                                                       placeholder="Email * (Address never made public)"
                                                                       value="{{ old('email') }}">
                                                                <input type="password" name="password"
                                                                       class="customer-login-input"
                                                                       placeholder="Enter Password *">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input customer-login-input"
                                                                           checked
                                                                           type="checkbox" name="remember_me"
                                                                           role="switch" id="subscription-checkbox">
                                                                    <label class="form-check-label"
                                                                           for="subscription-checkbox">
                                                                        Remember me on this browser for the next time I
                                                                        comment
                                                                    </label>
                                                                </div>
                                                                <hr>
                                                                <button
                                                                    class="btn btn-primary pull-right customer-login-input comment-submit-btn"
                                                                    disabled type="submit" data-form-id="customer-login"
                                                                    data-form-action="{{ route('post.comment.add', $post) }}">
                                                                    Submit
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="tab-pane fade" id="register" role="tabpanel"
                                                             aria-labelledby="profile-tab">
                                                            <form method="POST" id="customer-register"
                                                                  action="{{ route('post.comment.add', $post) }}"
                                                                  enctype="multipart/form-data"
                                                                  oninput='register_password_confirmation.setCustomValidity(register_password_confirmation.value !== register_password.value
                                                                    ? "Passwords do not match." : "")'>
                                                                @csrf
                                                                <input name="registration_request" value="yes"
                                                                       type="hidden">
                                                                <input type="email" class="customer-register-input"
                                                                       name="email"
                                                                       placeholder="Email * (Address never made public)"
                                                                       value="{{ old('email') }}">
                                                                <input type="text" class="customer-register-input"
                                                                       name="username"
                                                                       placeholder="Username"
                                                                       value="{{ old('username') }}">
                                                                <input type="password" class="customer-register-input"
                                                                       name="register_password"
                                                                       placeholder="Enter Password *">
                                                                <input type="password" class="customer-register-input"
                                                                       name="register_password_confirmation"
                                                                       placeholder="Confirm Password">
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        class="form-check-input customer-register-input"
                                                                        checked type="checkbox" name="subscribe"
                                                                        role="switch" id="subscription-checkbox">
                                                                    <label class="form-check-label"
                                                                           for="subscription-checkbox">Don’t miss out on
                                                                        all the special stuff! Join the Hamkke
                                                                        Club</label>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        class="form-check-input customer-register-input"
                                                                        checked
                                                                        type="checkbox" name="remember_me"
                                                                        role="switch" id="subscription-checkbox">
                                                                    <label class="form-check-label"
                                                                           for="subscription-checkbox">Remember me on
                                                                        this browser for the next time I comment</label>
                                                                </div>
                                                                <hr>
                                                                <button
                                                                    class="btn btn-primary pull-right customer-register-input
                                                                        comment-submit-btn" disabled
                                                                    type="button" data-form-id="customer-register"
                                                                    data-form-action="{{ route('post.comment.add', $post) }}">
                                                                    Submit
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <hr>
                                                <button class="btn btn-primary pull-right comment-submit-btn" disabled
                                                        type="button"
                                                        data-form-action="{{ route('post.comment.add', $post) }}"
                                                        id="submit-comment">Submit
                                                </button>
                                            @endif
                                        </div>

                                        <div class="title">Comments</div>
                                        @foreach($postComments as $postComment)
                                            <div class="comment-section @if(!$loop->first) top-line @endif">
                                                <span
                                                    class="font-bold">{{ $postComment->customer_name ?: $postComment->username }}</span>
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

                        <div class="row d-flex flex-row flex-wrap forum-row justify-content-between">
                            @foreach ($relatedPosts as $relatedPost)
                                @component('components.front.posts.post-preview-card-box-title-one', ['post' => $relatedPost])
                                @endcomponent
                            @endforeach
                        </div>
                        @component('components.front.ads-component-landscape')
                        @endcomponent
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

            $('#comment-textarea').on('input', function (e) {
                console.log('I was triggered');
                const commentContent = $(e.target).val()
                const submitBtn = '.comment-submit-btn'
                if (String(commentContent).length >= 1) {
                    $(submitBtn).prop('disabled', false);
                    @if(!customerIsLoggedIn())
                    $('#customerAuthForm').addClass('open');
                    @endif
                } else {
                    $(submitBtn).prop('disabled', true);
                    @if(!customerIsLoggedIn())
                    $('#customerAuthForm').removeClass('open');
                    @endif
                }
            });
        })(jQuery);
    </script>
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
