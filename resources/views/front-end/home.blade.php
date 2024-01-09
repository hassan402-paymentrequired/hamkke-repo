@php
    use App\Models\PostType;
@endphp
@extends('layouts.frontend.front-app', ['pageTitle' => 'Home'])

@section('content')
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('frontend-assets/carousel-img1.jpg') }}" class="d-block w-100" alt="img1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/carousel-img2.jpg') }}" class="d-block w-100" alt="img2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/carousel-img3.jpg') }}" class="d-block w-100" alt="img3">
            </div>
            <div class="carousel-overlay">
                <div class="title">
                    <h1>WELCOME</h1>
                    <p>{{ $coreSiteDetails->tagline() }}</p>
                </div>
                <img src="{{ asset('frontend-assets/carousel-overlay.png') }}" alt="carousel-overlay"/>
            </div>
        </div>
    </div>

    <div class="section1">
        <div class="container group1">
            <div class="row marginX">
                <div class="col-md-4">
                    <div class="title-div">
                        <div class="title-text">LATEST HALLYU NEWS</div>
                        <div class="title-box"></div>
                    </div>
                    <div class="paragraph">
                        <p>{{ $hallyuPostType->description }}</p>
                    </div>
                    <button class="link-div">
                        <a href="{{ route('post_type.view', ['post_type' => PostType::SLUG_HALLYU]) }}">
                            See More
                            <img src="{{ asset('frontend-assets/arrow_right_color.svg') }}" alt="right arrow icon"/>
                        </a>
                    </button>
                </div>

                @foreach ($latestHallyuNews as $post)
                    <div class="col-md-4">
                        <div class="card-box">
                            <div class="overlay">
                                <p>{{ $post->title }}</p>
                            </div>
                            <img src="{{ $post->featured_image }}" alt="Featured Image - {{ $post->title }}"/>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section2">
        <div class="container group2">
            <div class="title-div sm">
                <div class="title-text">ENGAGE IN FORUM</div>
                <div class="title-box"></div>
            </div>

            <div class="row marginX">
                @foreach($latestForumEntries as $forumEntry)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="d-flex profile-div align-items-center">
                                <img src="{{ $forumEntry->author_avatar ?: asset('frontend-assets/profile.jpg') }}"
                                     class="profile-img"
                                     alt="profile"><span>{{ $forumEntry->author_name }}</span>
                            </div>
                            <h5 class="card-title">{{ $forumEntry->title }}</h5>
                            <p class="card-text">{{ $forumEntry->body }}</p>

                            <div class="d-flex justify-content-between">
                                <div class="like-div">
                                    <span>{{ $forumEntry->likes }}</span><img
                                        src="{{ asset('frontend-assets/likes.png') }}" alt="..."/>
                                    <span>{{ $forumEntry->comments }}</span><img
                                        src="{{ asset('frontend-assets/comment.png') }}" alt="..."/>
                                </div>
                                <div class="comment-div">Posted {{ $forumEntry->created_at->diffForHumans() }}</div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <button class="link-div">
                    <a href="{{ route('post_type.view', ['post_type' => PostType::SLUG_FORUM]) }}">See More
                        <img src="{{ asset('frontend-assets/arrow_right_color.svg') }}" alt="right arrow icon"/>
                    </a>
                </button>
            </div>

        </div>
    </div>

    <div class="section3">
        <div class="container group3">
            <div class="title-div sm">
                <div class="title-text">LEARNING PACKAGES</div>
                <div class="title-box"></div>
            </div>

            <div class="row space-bottom marginX">
                <div class="col-md-4 learn-div">
                    <h1>Explore Our Learning Features, Products & Offers</h1>
                    <button class="link-div">
                        <a href="{{ route('post_type.view', ['post_type' => PostType::SLUG_LEARNING]) }}">
                            See More
                            <img src="{{ asset('frontend-assets/arrow_right_white.svg') }}" alt="white right arrow"/>
                        </a>
                    </button>
                </div>

                <div class="col-md-4 learn-div">
                    <div class="card">
                        <img src="{{ asset('frontend-assets/learn-e-material.svg') }}" alt="e-learning material"/>
                        <h4 class="title">E-Learning Materials</h4>
                        <p class="body">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 learn-div">
                    <div class="card">
                        <img src="{{ asset('frontend-assets/learn-phy-material.svg') }}"
                             alt="Physical learning material"/>
                        <h4 class="title">Physical Learning Materials</h4>
                        <p class="body">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row marginX">
                <div class="col-md-4 learn-div">
                    <div class="card">
                        <img src="{{ asset('frontend-assets/learn-brand.svg') }}" alt="Merch"/>
                        <h4 class="title">Branded Products</h4>
                        <p class="body">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 learn-div">
                    <div class="card">
                        <img src="{{ asset('frontend-assets/learn-content.svg') }}" alt="Learn Content"/>
                        <h4 class="title">Learning Contents</h4>
                        <p class="body">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 learn-div">
                    <div class="card">
                        <img src="{{ asset('frontend-assets/learn-engage.svg') }}" alt="Learn Engage"/>
                        <h4 class="title">Engage</h4>
                        <p class="body">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section4">
        <div class="container group4">
            <div class="box">
                <div class="row justify-content-between">
                    <div class="col-md-6 mx-auto podcast-div">
                        <img src="{{ asset('frontend-assets/podcast.png') }}" alt="Podcast Icon"/>
                    </div>

                    <div class="col-md-6 podcast-text">
                        <div class="title-div">
                            <div class="title-text">ENJOY OUR PODCAST CONTENT</div>
                            <div class="title-box"></div>
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                            Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a
                            galley of type and scrambled it to make a type specimen book.</p>
                        <button class="link-div">
                            <a href="podcast.html">See More
                                <img src="{{ asset('frontend-assets/arrow_right_color.svg') }}" alt="Right arrow icon"/>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('more_scripts')
    <script>
        HamkkeJsHelpers.convertQuillDeltaToHTML('#postContent', "{{ $post->body }}");
    </script>
    <script src="{{ asset('frontend-assets/pages/single-post.js') }}"></script>
@stop --}}
