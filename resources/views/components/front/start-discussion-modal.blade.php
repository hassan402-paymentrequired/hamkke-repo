<?php

use App\Models\Tag;

$tags = isset($tags) ? $tags : Tag::all();
?>
    <!-- Post Modal -->
<div class="modal fade light-style" id="postDiscussionModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="card-text">Start A Discussion</p>
                <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="post-box">
                    <form action="{{ route('forum.posts.create') }}" method="post"
                          enctype="multipart/form-data" id="postDiscussionForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="discussion-subject">Title</label>
                            <input class="form-control" name="topic" id="discussion-subject"
                                   value=""/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="discussion-tags">Tags</label>
                            <select class="select2 form-select" name="tags[]" id="discussion-tags"
                                    data-select-placeholder="Select Tags" multiple>
                                {{--                                <option selected>Select Tags</option>--}}
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="discussion-body">Body</label>
                            <div id="quill-editor">
                                <p id="discussion-body-editor"></p>
                            </div>
                            <textarea type="text" placeholder="type something" name="body" style="display: none;"
                                      id="discussion-body">{{ old('body') }}</textarea>
                        </div>
                        <button type="submit">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
