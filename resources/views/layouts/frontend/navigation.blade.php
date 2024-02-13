@php
    use App\Helpers\SiteSettings;use App\Models\PostType;

    /**
     * @var SiteSettings $coreSiteDetails
     */
@endphp
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('') }}">
            <img src="{{ $coreSiteDetails->siteLogo() }}" alt="logo"/>{{ $coreSiteDetails->siteName() }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('') }}">Home</a>
                </li>
                @foreach($registeredPostTypes as $postType)
                    @if($postType->id !== PostType::FORUM)
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('post_type.view', $postType) }}">{{ $postType->name }}</a>
                        </li>
                    @endif
                @endforeach
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('forum.posts') }}">Forum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about_us') }}">About Us</a>
                </li>
            </ul>

            {{--            <div class="d-flex socials justify-content-end">--}}
            {{--                @include('components.front-social-links-section')--}}
            {{--            </div>--}}

            <div class="navbtn">
                <button>
                    <a class="nav-link"
                       onclick="return HamkkeJsHelpers.confirmationAlert('This Feature is currently unavailable', 'Oops!', 'info').then(completeAction => false)"
                       href="javascript:void(0)">
                        <img src="{{ asset('frontend-assets/store.svg') }}" alt="hamkke store - icon"/>Store
                    </a>
                </button>

                <button class="bg-filled">
                    <a class="nav-link"
                       onclick="return HamkkeJsHelpers.confirmationAlert('This Feature is currectly unavailable', 'Oops!', 'info').then(completeAction => false)"
                       href="javascript:void(0)"><img src="{{ asset('frontend-assets/cart.svg') }}" alt="Cart icon"/>Cart</a>
                </button>
                @auth(CUSTOMER_GUARD_NAME)
                    <a class="text-hamkke-purple nav-login-link" href="javascript:void(0);">
                        @if($customerAuthUser->avatar)
                        <img src="{{ $customerAuthUser->avatar }}" alt="profile"
                             style="border-radius: 50%; max-height: 30px;">
                        @else
                            <em class="fa fa-user-circle"></em>
                        @endif
                        <span class="ml-1">{{ $customerAuthUser->getName() }}</span>
                    </a>
                @endauth
                @guest(CUSTOMER_GUARD_NAME)
                    <a class="text-hamkke-purple nav-login-link" href="{{ route('customer.auth.login') }}">
                        <em class="fa fa-arrow-right-to-bracket"></em>
                        <span class="ml-1">Login</span>
                    </a>
                @endguest
            </div>
        </div>

    </div>
</nav>
