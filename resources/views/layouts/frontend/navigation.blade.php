@php
    use App\Helpers\SiteSettings;

    /**
     * @var SiteSettings $coreSiteDetails
     */
@endphp
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('') }}"><img src="{{ $coreSiteDetails->siteLogo() }}"
                                                          alt="logo"/>{{ $coreSiteDetails->siteName() }}</a>
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
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('post_type.view', $postType) }}">{{ $postType->name }}</a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about_us') }}">About Us</a>
                </li>
            </ul>

            <div class="d-flex socials justify-content-end">
                @include('components.front-social-links-section')
            </div>

            <div class="navbtn">
                <button>
                    <a class="nav-link"
                       onclick="return HamkkeJsHelpers.confirmationAlert('This Feature is currently unavailable', 'Oops!', 'info').then(completeAction => false)"
                       href="javascript:void(0)">
                        <img src="{{ asset('frontend-assets/store.svg') }}" alt="hamkke store - icon"/>Store
                    </a>
                </button>

                <button>
                    <a class="nav-link"
                       onclick="return HamkkeJsHelpers.confirmationAlert('This Feature is currectly unavailable', 'Oops!', 'info').then(completeAction => false)"
                       href="javascript:void(0)"><img src="{{ asset('frontend-assets/cart.svg') }}" alt="Cart icon"/>Cart</a>
                </button>
            </div>
        </div>

    </div>
</nav>
