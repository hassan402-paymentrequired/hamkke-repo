@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('main-content')
    <div class="row">
        <!-- Sales last year -->

        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-success mb-2 rounded">
                        <i class="ti ti-align-left ti-md"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Published Posts</h5>
                    <small class="text-muted">This year</small>
                    <p class="mb-2 mt-1">{{ $cardStats['posts_count'] }}</p>
{{--                    <div class="pt-1">--}}
{{--                        <span class="badge bg-label-secondary">-12.2%</span>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-primary mb-2 rounded">
                        <i class="ti ti-message ti-md"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Comments</h5>
                    <small class="text-muted">Comments</small>
                    <p class="mb-2 mt-1">{{ $cardStats['comments'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded">
                        <i class="ti ti-users ti-md"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Likes</h5>
                    <small class="text-muted">This year</small>
                    <p class="mb-2 mt-1">{{ $cardStats['likes'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded">
                        <i class="ti ti-currency-dollar ti-md"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Customers</h5>
                    <small class="text-muted">This year</small>
                    <p class="mb-2 mt-1">{{ $cardStats['customers'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Recent Published Posts</h5>
                    </div>
                </div>
                <div class="card-body">
                    @include('components.posts-table', ['posts' => $recentPosts])
                </div>
            </div>

        </div>
    </div>
@endsection

@section('more-script')
    <script src="{{ assetWithVersion('cms-assets/js/dashboards-crm.js') }}"></script>
@endsection
