@php use App\Helpers\PostParser; @endphp
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

                        <div class="row ">
                            @if (empty(getAuthUserPrioritizeCustomer()))
                                <div class="col-md-12">
                                    <span class="post-comment-button">
                                        {{ $discussions->count() }}
                                        <img src="{{ asset('frontend-assets/comment.png') }}" alt="..." />
                                        <span class="text">Replies</span>
                                    </span>
                                    <p>Please
                                        <a href="{{ route('customer.auth.login') }}"
                                            class="text-decoration-none text-hamkke-purple">Login</a>
                                        to participate in this thread!
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="row light-style">
                            @if (getAuthUserPrioritizeCustomer())
                                <div class="col-md-12">
                                    <div class="post-box">
                                        <form action="{{ route('forum.posts.reply', [$forumPost]) }}" method="post"
                                            enctype="multipart/form-data" id="threadReplyForm">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label" for="reply-content">Write a reply</label>
                                                <div id="reply-content-editor">
                                                    <p id="reply-content-editor-p"></p>
                                                </div>
                                                <textarea type="text" placeholder="type something" name="reply-body" style="display: none;" id="reply-content">{{ old('reply-body') }}</textarea>
                                            </div>
                                            <button type="submit">Reply</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-12 dropdown">
                                <div class="post-comment-content">
                                        {{-- <div class="title">Replies</div> --}}
                                    <div class="comment">
                                        @foreach ($discussions as $reply)
                                            @php
                                                $parsedReplyBody = (new PostParser($reply))->parsePostBody()->render();
                                            @endphp
                                            <div class="comment-section @if (!$loop->first) top-line @endif">
                                                <div class="float-end text-muted">{{ $reply->created_at->format('D, M jS Y g:i A') }}</div>
                                                <span class="font-bold">{{ $reply->posterName() }}</span>
                                                <div>{!!$parsedReplyBody !!}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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
    <script src="{{ assetWithVersion('frontend-assets/pages/forum-posts.js') }}"></script>
@stop
