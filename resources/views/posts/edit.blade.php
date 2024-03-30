@extends('layouts.app', ['pageTitle' => 'Post::Edit'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Posts /{{ $post->id }}/</span> Edit</h4>

    <form id="postUpdateForm" action="{{ route('admin.post.update', ['post' => $post->id]) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Full Editor -->
            <div class="col-md-9">
                <div class="card mb-4">
                    <h5 class="card-header">Edit Post</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
                            <img src="{{ getCorrectAbsolutePath($post->featured_image) }}" alt="featured-image"
                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedFeaturedImage"/>
                        </div>
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
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
                            <input type="text" class="form-control" value="{{ old('post_title', $post->title) }}"
                                   id="formTitle" name="post_title" required
                                   placeholder="Title"/>
                        </div>
                        <div class="mb-3">
                            <label for="postContent" class="form-label">Post Content</label>
                            <div id="full-editor">
                                <p id="postContentEditor"></p>
                            </div>
                            <textarea name="post_content" style="display: none"
                                      id="postContent">{{ old('post_content', $post->body) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="postSummary" class="form-label">Post Summary</label>
                            <textarea class="form-control" id="postSummary" name="post_summary"
                                      rows="4">{{ old('post_summary', $post->summary) }}</textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes and Preview</button>
                        </div>
                    </div>
                </div>
                <!-- /Full Editor -->
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="postStatus" class="form-label">Post Status</label>
                            <select required class="form-select" id="postStatus" name="post_status"
                                    aria-label="Post Status Selection">
                                @foreach($postStatuses as $postStatus)
                                    <option value="{{ $postStatus->value }}"
                                        {{ old('post_status', $post->post_status_id) == $postStatus->value ? 'selected' : '' }}>
                                        {{ $postStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="postType" class="form-label">Post Type</label>
                            <select class="form-select" id="postType" name="post_type" aria-label="Post Type Selection">
                                @foreach($postTypes as $postType)
                                    <option value="{{ $postType->id }}"
                                        {{ old('post_type', $post->post_category->post_type_id) == $postType->id ? 'selected' : '' }}>
                                        {{ $postType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="postCategory" class="form-label">Post Category</label>
                            <select class="form-select" id="postCategory" data-old-selection="{{ old('post_category', $post->post_category_id) }}" name="post_category"
                                    aria-label="Post Category Selection">
                                <option value="">Select Post Category</option>
                                @foreach($postCategories as $postCategory)
                                    <option value="{{ $postCategory->id }}"
                                        {{ old('post_category', $post->post_category_id) == $postCategory->id ? 'selected' : '' }}>
                                        {{ "{$postCategory->post_type->name}::{$postCategory->name}" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select class="select2 form-select" id="tags" data-maximumSelectionLength="3" name="post_tags[]"
                                    data-selectPlaceholder="Select Post Tags" aria-label="Post Tags Selection" multiple>
                                <option value="">Select Post Tags</option>
                                @php $prevSelectedTags = old('post_tags', $postTags->pluck('id')->toArray()); @endphp
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                        {{ !empty($prevSelectedTags) && in_array($tag->id, $prevSelectedTags) ? 'selected' : '' }}>
                                        {{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @form_field_error('post_tags')
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="{{ assetWithVersion("cms-assets/js/pages/post-fields-manager.js") }}"></script>
    <script src="{{ assetWithVersion("cms-assets/js/pages/edit-post.js") }}"></script>
@endsection
