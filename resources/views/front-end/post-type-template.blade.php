@extends('layouts.frontend.front-app', ['pageTitle' => "Post Type ::: {$postType->name}"])

@section('content')

    <section class="section hallyu-div">
        <div class="container">
            <div class="row marginX">
                <div class="nav col-md-3 nav-pills paddingR sticky-top" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <span class="sticky-top">
                        @foreach($postCategories as $category)
                            <button
                                class="nav-link {{ $loop->first ? 'active' : ''}} d-flex align-items-left align-items-center"
                                id="v-{{ $category->slug }}-tab" data-bs-toggle="pill"
                                data-bs-target="#v-{{ $category->slug }}"
                                type="button" role="tab" aria-controls="v-{{ $category->slug }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false'}}">
                                <img src="{{ $category->navigation_icon }}" alt="{{ $category->name }} nav icon"/>
                                {{ $category->name }}
                            </button>

                        @endforeach
                    </span>
                </div>

                <div class="col-md-9 paddingR tab-content" id="v-pills-tabContent">
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-3">
                                <div class="forum">
                                    <div class="card d-flex justify-content-between post-listing-card">
                                        <img class="card-img-top" src="{{ getCorrectAbsolutePath($post->featured_image) }}"
                                             alt="{{ $post->title }}"/>
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <div class="d-flex profile-div justify-content-between mb-1">
                                            <span>{{ $post->author_name }}</span>
                                            <div class="comment-div">...
                                                Posted {{ $post->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <p class="card-text post-summary">{{ \Str::limit($post->summary, 200) }}
                                            <span>
                                                    <a href="{{ route('post.view', compact('post')) }}">See More</a>
                                                </span>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-3 like-div post-impression">
                                                <span>{{ $post->likes }}<img
                                                        src="{{ asset('frontend-assets/likes.png') }}"
                                                        alt="..."/></span>
                                            </div>
                                            <div class="col-md-9 dropdown post-impression">
                                                <span class="dropdown-button">{{ $post->comments }}
                                                    <img src="{{ asset('frontend-assets/comment.png') }}" alt="..."/>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('more_scripts')
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
