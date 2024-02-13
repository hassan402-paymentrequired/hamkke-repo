<?php
/**
 * @var \App\Models\ForumPost $forumPost
 */
?>
@extends('layouts.frontend.front-app', ['pageTitle' => "Forum ::: Recent Posts"])

@section('content')

    <section class="section category-posts-div forum-div">
        <div class="container">
            <div class="row marginX">
                <div class="nav col-md-3 paddingR nav-pills sticky-top" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <span class="sticky-top">
                        @include('components.front.start-thread-button')

                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <img src="{{ asset('frontend-assets/tabs.svg') }}" alt="View Tabs Icon"/>
{{--                                <span>View Tabs</span>--}}
                            </button>

                            <div class="collapse navbar-collapse" id="navbarNav2">
                                <ul class="navbar-nav">
                                    <li class="nav-item @if(empty(request()->tag)) active @endif">
                                        <button class="nav-link @if(empty(request()->tag)) active @endif d-flex align-items-left align-items-center"
                                                id="v-pills-language-tab" type="button">
                                            <a href="{{ route('forum.posts') }}">All</a>
                                        </button>
                                    </li>
                                    @foreach($tags as $tag)
                                        <li class="nav-item @if(request()->tag == $tag->slug) active @endif">
                                            <button class="nav-link @if(request()->tag == $tag->slug) active @endif d-flex align-items-left align-items-center"
                                                    id="v-pills-language-tab" type="button">
                                                <a href="{{ route('forum.posts', ['tag' => $tag->slug]) }}"> {{ $tag->name }} </a></button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </nav>
                    </span>
                </div>

                <div class="col-md-9 paddingR tab-content pt-0" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel"
                         aria-labelledby="v-pills-all-tab">
                        <div class="forum">
                            <div class="d-flex flex-row flex-wrap forum-row justify-content-between">
                                @foreach($forumPosts as $forumPost)
                                    <div class="forum card">
                                        <div class="space-div">
                                            @php
                                                $forumPoster = $forumPost->getPoster();
                                            @endphp
                                            <div class="d-flex profile-div align-items-center mt-0">
                                                <img src="{{ asset($forumPoster->avatar) }}" alt="profile">
                                                <span>{{ $forumPoster->name }}</span>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="{{ route('forum.posts.view', [$forumPost]) }}">
                                                        <h5 class="card-title">{{ $forumPost->topic }}</h5>
                                                    </a>
                                                </div>
                                            </div>
                                            <p class="card-text">{{ $forumPost->getPostSummary() }} ...</p>
                                            <div class="like-div">
                                                <span>0</span>
                                                <img src="{{ asset('frontend-assets/likes.png') }}" alt="...">

                                                <span>{{ $forumPost->forum_discussions()->count() }}</span>
                                                <img src="{{ asset('frontend-assets/comment.png') }}" alt="...">

                                                <span>Posted {{ $forumPost->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
