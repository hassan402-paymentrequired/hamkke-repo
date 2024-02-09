@extends('layouts.app', ['pageTitle' => 'All Tags'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Tags /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Tags</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 offset-md-10 mb-3 mt-3">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#createTagModal">
                            Add New Tags
                        </button>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <caption>Tags</caption>
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($tags as $tag)
                            <tr>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->slug }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit-category"
                                               onclick="updateTag(
                                                   '{{ $tag->id }}',
                                                   '{{ route('admin.tag.update', compact('tag')) }}'
                                               )" href="javascript:void(0);">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete-tag"
                                               onclick="HamkkeJsHelpers.submitActionForm(
                                                        '{{ route('admin.tag.delete', compact('tag')) }}',
                                                        'This tag will no longer be available'
                                                    )"
                                               href="javascript:void(0);">
                                                <i class="ti ti-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Tags Found..</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade animate__animated fadeIn" id="createTagModal" tabindex="-1"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('admin.tag.create') }}" enctype="multipart/form-data"
                                  method="POST"
                                  id="categoryCreationForm">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tagName">Create New Tag</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    {{-- <hr class="my-0" /> --}}
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="createTagName" class="form-label">Name</label>
                                            <input type="text" id="createTagName" name="name" class="form-control"
                                                  value="{{ old('name') }}" placeholder="Enter Tag Name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade animate__animated fadeIn" id="editTagModal" tabindex="-1"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="" method="POST" enctype="multipart/form-data" id="tagUpdateForm">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tagName">Edit Tag</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="editTagName" class="form-label">Name</label>
                                            <input type="text" id="editTagName" name="edit_tag_name"
                                                   value="{{ old('edit_tag_name') }}"
                                                   class="form-control" placeholder="Enter Tag Name"/>
                                        </div>
                                        <input name="tag_id" style="display: none;" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection

@section('more-scripts')
    <script>
        const TAGS = {
            @foreach($tags as $tag)
            "{{ $tag->id }}": @json($tag),
            @endforeach
        };
        const updateFormId = 'tagUpdateForm';
        function updateTag(tagID, url, oldData = null)
        {
            let formData = oldData
            if(!formData){
                const tagData = TAGS[tagID];
                formData = {
                    "tag_id" : tagData.id,
                    "edit_tag_name": tagData.name
                }
            }
            $(`#${updateFormId}`).attr('action', url);
            HamkkeJsHelpers.populateFormWithData(formData, updateFormId);
            $("#editTagModal").modal('show');
        }
        $(document).on('ready', function () {
            @if(collect(old())->hasAny(['edit_tag_name']))
            const oldUpdateData = @json(old());
            updateTag(oldUpdateData.tag_id, '{{ route('admin.tag.update', ['tag' => old('tag_id')]) }}');
            @endif

            @if(collect(old())->hasAny(['name']))
            const oldCreationData = @json(old());
            HamkkeJsHelpers.populateFormWithData(oldCreationData, 'tagCreationForm');
            @endif
        });

    </script>
@endsection
