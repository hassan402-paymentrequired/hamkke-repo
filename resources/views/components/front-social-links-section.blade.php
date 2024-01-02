
@if($coreSiteDetails->getSocialLink(SOCIAL_LINK_FACEBOOK))
    <div class="icon-bg">
        <a href="{{ $coreSiteDetails->getSocialLink(SOCIAL_LINK_FACEBOOK) }}">
            <img src="{{ asset('frontend-assets/facebook.png') }}" alt="facebook icon"/>
        </a>
    </div>
@endif
@if($coreSiteDetails->getSocialLink(SOCIAL_LINK_INSTAGRAM))
    <div class="icon-bg">
        <a href="{{ $coreSiteDetails->getSocialLink(SOCIAL_LINK_INSTAGRAM) }}">
            <img src="{{ asset('frontend-assets/instagram.png') }}" alt="instagram icon"/>
        </a>
    </div>
@endif
@if($coreSiteDetails->getSocialLink(SOCIAL_LINK_TWITTER))
    <div class="icon-bg">
        <a href="{{ $coreSiteDetails->getSocialLink(SOCIAL_LINK_TWITTER) }}">
            <img src="{{ asset('frontend-assets/twitter.png') }}" alt="twitter icon"/>
        </a>
    </div>
@endif
@if($coreSiteDetails->getSocialLink(SOCIAL_LINK_YOUTUBE))
    <div class="icon-bg">
        <a href="{{ $coreSiteDetails->getSocialLink(SOCIAL_LINK_YOUTUBE) }}">
            <img src="{{ asset('frontend-assets/linkedin.png') }}" alt="youtube icon"/>
        </a>
    </div>
@endif
