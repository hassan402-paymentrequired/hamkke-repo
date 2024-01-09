@extends('layouts.frontend.front-app', ['pageTitle' => "Post Type ::: {$postType->name}"])

@section('content')

    <section class="section hallyu-div">
        <div class="container">
            <div class="row marginX">
                <div class="nav col-md-3 nav-pills paddingR sticky-top" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <span class="sticky-top">
                        @foreach($postCategories as $category)
                            <button class="nav-link {{ $loop->first ? 'active' : ''}} d-flex align-items-left align-items-center"
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
                    @foreach($postCategories as $category)
                        <div class="tab-pane fade show {{ $loop->first ? 'active' : ''}}" id="v-{{ $category->slug }}" role="tabpanel"
                             aria-labelledby="v-{{ $category->slug }}-tab">
                            <div class="forum">
                                @foreach($category->postsWithCommentsAndLikes() as $post)
                                    <div
                                        class="card d-flex align-items-center justify-content-between post-listing-card">
                                        <img class="card-img-top" src="{{ $post->featured_image }}"
                                             alt="{{ $post->title }}"/>
                                        <div class="d-flex profile-div justify-content-between align-items-center clearfix">
                                            <h5 class="card-title">{{ $post->title }}</h5>
                                            <div class="d-flex align-items-center">
                                                <span>{{ $post->author_name }}</span>
                                                <div class="comment-div">...
                                                    Posted {{ $post->created_at->diffForHumans() }} ago
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $post->summary }}
                                            <span>
                                                <a href="{{ route('post.view', compact('post')) }}">See More</a>
                                            </span>
                                        </p>

                                        <div class="d-flex">
                                            <div class="col-md-2 col-3 like-div">
                                                <span>{{ $post->likes }}<img
                                                        src="{{ asset('frontend-assets/likes.png') }}"
                                                        alt="..."/></span>
                                            </div>

                                            <div class="col-md-10 col-9 dropdown">
                                                <span class="dropdown-button">{{ $post->comments }}
                                                    <img src="{{ asset('frontend-assets/comment.png') }}" alt="..."/>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('more_scripts')
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop
