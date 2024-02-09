@extends('layouts.app', ['pageTitle' => 'Post::Create'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Posts /</span> Add New</h4>

    <form id="postCreationForm" action="{{ route('admin.post.create') }}" class="needs-validation" method="POST" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <!-- Full Editor -->
            <div class="col-md-9">
                <div class="card mb-4">
                    <h5 class="card-header">Add New Post</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="" alt="featured-image"
                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedFeaturedImage"/>
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Click to Upload Featured Image</span>
                                    <em class="ti ti-upload d-block d-sm-none"></em>
                                    <input type="file" id="upload" class="upload-featured-image-input" hidden
                                           accept="image/png, image/jpeg" name="featured_image"/>
                                </label>
                                <button type="button" class="btn btn-label-secondary reset-featured-image-input mb-3">
                                    <em class="ti ti-refresh-dot d-block d-sm-none"></em>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>
                                <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                            </div>
                        </div>
                        <hr class="my-0"/>
                        <div class="mb-3">
                            <label for="formTitle" class="form-label">Post Title</label>
                            <input type="text" class="form-control" value="{{ old('post_title') }}" id="formTitle"
                                   name="post_title"
                                   placeholder="Title"/>
                            @form_field_error('post_title')
                        </div>
                        <div class="mb-3">
                            <label for="postContent" class="form-label">Post Content</label>
                            <div id="full-editor">
                                <p id="postContentEditor"></p>
                            </div>
                            <textarea name="post_content" style="display: none;"
                                      id="postContent">{{ old('post_content') }}</textarea>
                            @form_field_error('post_content')
                        </div>
                        <div class="mb-3">
                            <label for="postSummary" class="form-label">Post Summary</label>
                            <textarea class="form-control" id="postSummary" name="post_summary"
                                      rows="4">{{ old('post_summary') }}</textarea>
                            @form_field_error('post_summary')
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-outline primary me-2">Save changes and Preview</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="postType" class="form-label">Post Type</label>
                            <select class="form-select" id="postType" name="post_type" aria-label="Post Type Selection">
                                <option value="">Select Post Type</option>
                                @foreach($postTypes as $postType)
                                    <option value="{{ $postType->id }}"
                                        {{ old('post_type') == $postType->id ? 'selected' : '' }}>
                                        {{ $postType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="postCategory" class="form-label">Post Category</label>
                            <select class="form-select" id="postCategory" name="post_category"
                                    aria-label="Post Category Selection">
                                <option value="">Select Post Type</option>
                                @foreach($postCategories as $postCategory)
                                    <option value="{{ $postCategory->id }}"
                                        {{ old('post_category') == $postCategory->id ? 'selected' : '' }}>
                                        {{ "{$postCategory->post_type->name}::{$postCategory->name}" }}</option>
                                    )
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Full Editor -->
        </div>
    </form>
@endsection

@section('more-scripts')
    <script>
        const POST_TYPES = {
            @foreach($postTypes as $postType)
            {{$postType->id}}: @json($postType),
            @endforeach
        };
        const CATEGORIES = @json($postCategories);
    </script>
    <script src="{{ asset("cms-assets/js/pages/post-fields-manager.js") }}"></script>
    <script src="{{ asset("cms-assets/js/pages/create-post.js") }}"></script>
@endsection
