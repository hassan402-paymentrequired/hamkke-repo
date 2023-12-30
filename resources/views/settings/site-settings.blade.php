<?php

use App\Models\GeneralSetting;

?>
@extends('layouts.app', ['pageTitle' => 'Settings::General'])

@section('more-styles')
@endsection

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">General</span> Settings</h4>

    <div class="row">
        <div class="col-md-12">
            @include('components.pages.settings-navtabs')
            <div class="card mb-4">
                <h5 class="card-header">Core Site Settings</h5>

                <form id="formAccountSettings" method="POST" action="{{ route('settings.general') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $siteSettings->siteLogo() }}" alt="user-avatar"
                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar"/>
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Click to Upload Logo</span>
                                    <em class="ti ti-upload d-block d-sm-none"></em>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                           accept="image/png, image/jpeg" name="site_logo"/>
                                </label>
                                <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                    <em class="ti ti-refresh-dot d-block d-sm-none"></em>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0"/>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-md-0 mb-4">
                                <div class="mb-3 col-md-12">
                                    <label for="siteName" class="form-label">Site Name</label>
                                    <input class="form-control" type="text" id="siteName" name="site_name"
                                           value="{{ $siteSettings->siteName() }}" autofocus/>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="tagline" class="form-label">Tagline</label>
                                    <input class="form-control" type="text" name="tagline" id="tagline"
                                           value="{{ $siteSettings->tagline() }}"/>
                                </div>
                                <div class="card">
                                    <h5 class="card-header pb-1">Connected Accounts</h5>
                                    <div class="card-body">
                                        <p class="mb-4">Display content from your connected accounts on your site</p>
                                        <!-- Connections -->
                                        <div class="mb-3 col-md-6">
                                            <label for="facebook_link" class="form-label">
                                                <img src="{{ asset('images/brands/facebook.png') }}" alt="facebook icon"
                                                     class="me-3" height="30"/> Facebook</label>
                                            <input class="form-control" type="text" name="social_facebook"
                                                   id="facebook_link"
                                                   value="{{ $siteSettings->getSocialLink('facebook') }}"/>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="twitter_link" class="form-label">
                                                <img src="{{ asset('images/brands/twitter.png') }}" alt="twitter icon"
                                                     class="me-3" height="30"/> Twitter</label>
                                            <input class="form-control" type="text" name="social_twitter"
                                                   id="twitter_link"
                                                   value="{{ $siteSettings->getSocialLink('twitter') }}"/>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="instagram_link" class="form-label">
                                                <img src="{{ asset('images/brands/instagram.png') }}"
                                                     alt="instagram icon" class="me-3" height="30"/>
                                                Instagram</label>
                                            <input class="form-control" type="text" name="social_instagram"
                                                   id="instagram_link"
                                                   value="{{ $siteSettings->getSocialLink('instagram') }}"/>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="youtube_link" class="form-label">
                                                <img src="{{ asset('images/brands/instagram.png') }}"
                                                     alt="instagram icon" class="me-3" height="30"/>
                                                YouTube</label>
                                            <input class="form-control" type="text" name="social_youtube"
                                                   id="youtube_link"
                                                   value="{{ $siteSettings->getSocialLink('youtube') }}"/>
                                        </div>
                                        <!-- /Connections -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
                <!-- /Account -->
            </div>
        </div>
    </div>
@endsection

@section('more-scripts')
    <script src="{{ asset('cms-assets/js/pages/site-settings.js') }}"></script>
@endsection
