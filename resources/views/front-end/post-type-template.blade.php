@php
    use Illuminate\Database\Events\QueryExecuted;
    use Illuminate\Support\Facades\DB;
@endphp
@extends('layouts.frontend.front-app', ['pageTitle' => "Post Type ::: {$postType->name}"])

@section('content')
    <section class="section category-posts-div">
        <div class="container">
            <div class="row marginX">
                <div class="nav col-md-3 nav-pills paddingR sticky-top" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <span class="sticky-top">
                        @foreach ($postCategories as $category)
                            <button
                                class="nav-link {{ $selectedCategory && $category->id === $selectedCategory->id ? 'active' : '' }} d-flex align-items-left align-items-center"
                                id="v-pills-{{ $category->slug }}-tab" data-bs-toggle="pill"
                                data-bs-target="#v-{{ $category->slug }}" type="button" role="tab"
                                aria-controls="v-{{ $category->slug }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                <a class="decoration-0"
                                    href="{{ route('post_type.view', ['post_type' => $postType->slug, 'post_category' => $category->slug]) }}">
                                    <img src="{{ $category->navigation_icon }}" alt="{{ $category->name }} nav icon" />
                                    {{ $category->name }}
                                </a>
                            </button>
                        @endforeach
                    </span>
                </div>

                <div class="col-md-9 paddingR tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active"
                        id="v-pills-{{ $selectedCategory ? $selectedCategory->slug : '' }}" role="tabpanel"
                        aria-labelledby="v-pills-{{ $selectedCategory ? $selectedCategory->slug : '' }}-tab">
                        <div class="forum">
                            <div class="d-flex flex-row flex-wrap forum-row justify-content-between">
                                @foreach ($posts as $post)
                                    <div class="card">
                                        <a href="{{ route('post.view', compact('post')) }}">
                                            <img class="card-img-top"
                                                src="{{ getCorrectAbsolutePath($post->featured_image) }}"
                                                alt="{{ $post->title }}" />
                                            <div class="space-div">
                                                <div class="d-flex profile-div align-items-center">
                                                    <img src="{{ getCorrectAbsolutePath($post->author_avatar) }}"
                                                        class="profile-img" alt="profile">
                                                    <span>{{ $post->author_name }}</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h5 class="card-title">{{ $post->title }}</h5>
                                                    </div>
                                                </div>
                                                <p class="card-text">
                                                    {{ \Str::limit($post->summary, 200) }} <br>
                                                </p>

                                                <div class="like-div">
                                                    <span>{{ $post->likes->count() }}</span>
                                                    <img src="{{ asset('frontend-assets/likes.png') }}" alt="...">
                                                    <span>{{ $post->comments->count() }}</span>
                                                    <img src="{{ asset('frontend-assets/comment.png') }}" alt="...">
                                                    <span>Posted {{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="w-100">
                                    {{ $posts->links('vendor.pagination.customer-front.float-right') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- @section('more-scripts') --}}
{{--    <script> --}}
{{--        console.log(@json($queryLog)) --}}
{{--    </script> --}}
{{-- @stop --}}

{{-- <span>
                                                    <a href="{{ route('post.view', compact('post')) }}">See More</a>
                                                </span> --}}
