@extends('layouts.app', ['pageTitle' => 'All Categories'])

@section('main-content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Categories /</span> All</h4>

    <div class="row">
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Categories</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 offset-md-10 mb-3 mt-3">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#createCategoryModal">
                            Add New Category
                        </button>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <caption>Post Categories</caption>
                        <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Post Type</th>
                            <th>Name</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($postCategories as $category)
                            <tr>
                                <td><img src="{{ $category->navigation_icon }}" width="50px" alt="Navigatio Icon"/></td>
                                <td>{{ $category->post_type->name }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit-category"
                                               onclick="updateCategory(
                                                   '{{ $category->id }}',
                                                   '{{ route('admin.category.update', compact('category')) }}'
                                               )" href="javascript:void(0);">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete-category"
                                               onclick="HamkkeJsHelpers.submitActionForm(
                                                        '{{ route('admin.category.delete', compact('category')) }}',
                                                        'This user will no longer have access to the application'
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
                                <td colspan="6" class="text-center">No Posts Found..</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade animate__animated fadeIn" id="createCategoryModal" tabindex="-1"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('admin.category.create') }}" enctype="multipart/form-data"
                                  method="POST"
                                  id="categoryCreationForm">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="categoryName">Create New Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
                                        <img src="{{ asset('images/avatar-placeholder-640.png') }}"
                                             alt="Category Navigation Icon" class="d-block w-px-100 h-px-100 rounded"
                                             id="uploadedNavigationIcon"/>
                                        <div class="button-wrapper">
                                            <label for="navigationIcon" class="btn btn-primary me-2 mb-3" tabindex="0">
                                                <span class="d-none d-sm-block">Upload Navigation Icon</span>
                                                <em class="ti ti-upload d-block d-sm-none"></em>
                                                <input type="file" id="navigationIcon" hidden
                                                       accept="image/png, image/jpeg" required name="navigation_icon"/>
                                            </label>
                                            <button type="button" id="resetNavigationIcon"
                                                    class="btn btn-label-secondary mb-3">
                                                <em class="ti ti-refresh-dot d-block./.. d-sm-none"></em>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                                        </div>
                                    </div>
                                    {{-- <hr class="my-0" /> --}}
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="createCategoryName" class="form-label">Name</label>
                                            <input type="text" id="createCategoryName" name="name" class="form-control"
                                                  value="{{ old('name') }}" placeholder="Enter Category Name"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="postType" class="form-label">Post Type</label>
                                            <select class="form-select" id="postType" name="post_type"
                                                    aria-label="Post Type Selection">
                                                <option value="">Select Post Type</option>
                                                @foreach($postTypes as $postType)
                                                    <option value="{{ $postType->id }}"
                                                        {{ old('post_type') == $postType->id ? 'selected' : '' }}>
                                                        {{ $postType->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="createCategoryDescription" class="form-label">
                                                Description
                                            </label>
                                            <textarea id="createCategoryDescription" class="form-control"
                                                      name="description" placeholder="Enter Category Description">
                                                {{ old('description') }}
                                            </textarea>
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
                <div class="modal fade animate__animated fadeIn" id="editCategoryModal" tabindex="-1"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="" method="POST" enctype="multipart/form-data" id="categoryUpdateForm">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="categoryName">Edit Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
                                        <img src="{{ asset('images/avatar-placeholder-640.png') }}"
                                             alt="Category Navigation Icon" class="d-block w-px-100 h-px-100 rounded"
                                             id="uploadedNavigationIcon_edit"/>
                                        <div class="button-wrapper">
                                            <label for="navigationIcon_edit" class="btn btn-primary me-2 mb-3"
                                                   tabindex="0">
                                                <span class="d-none d-sm-block">Upload Navigation Icon</span>
                                                <em class="ti ti-upload d-block d-sm-none"></em>
                                                <input type="file" id="navigationIcon_edit" hidden
                                                       accept="image/png, image/jpeg"
                                                       name="edit_category_navigation_icon"/>
                                            </label>
                                            <button type="button" id="resetNavigationIcon_edit"
                                                    class="btn btn-label-secondary mb-3">
                                                <em class="ti ti-refresh-dot d-block./.. d-sm-none"></em>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                                        </div>
                                    </div>
                                    <hr class="my-0"/>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="editCategoryName" class="form-label">Name</label>
                                            <input type="text" id="editCategoryName" name="edit_category_name"
                                                   value="{{ old('edit_category_name') }}"
                                                   class="form-control" placeholder="Enter Category Name"/>
                                        </div>
                                        <input name="category_id" style="display: none;" value="">
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="postType" class="form-label">Post Type</label>
                                            <select class="form-select" id="postType" name="edit_category_post_type"
                                                    aria-label="Post Type Selection">
                                                <option value="">Select Post Type</option>
                                                @foreach($postTypes as $postType)
                                                    <option value="{{ $postType->id }}"
                                                        {{ old('edit_category_post_type') == $postType->id ? 'selected' : '' }}>
                                                        {{ $postType->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="editCategoryDescription" class="form-label">Description</label>
                                            <textarea id="editCategoryDescription" name="edit_category_description"
                                                      class="form-control"
                                                      placeholder="Enter Category Description">{{ old('edit_category_description') }}</textarea>
                                        </div>
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
        const CATEGORIES = {
            @foreach($postCategories as $category)
            "{{ $category->id }}": @json($category),
            @endforeach
        };
        const updateFormId = 'categoryUpdateForm';
        function updateCategory(categoryID, url, oldData = null)
        {
            let formData = oldData
            if(!formData){
                const categoryData = CATEGORIES[categoryID];
                formData = {
                    "category_id" : categoryData.id,
                    "edit_category_name": categoryData.name,
                    "edit_category_post_type": categoryData.post_type_id,
                    "edit_category_description": categoryData.description
                }
                $('#uploadedNavigationIcon_edit').attr('src', categoryData.navigation_icon);
            }
            $(`#${updateFormId}`).attr('action', url);
            HamkkeJsHelpers.populateFormWithData(formData, updateFormId);
            $("#editCategoryModal").modal('show');
        }
        $(document).on('ready', function () {
            @if(collect(old())->hasAny(['edit_category_name', 'edit_category_post_type', 'edit_category_description']))
            const oldUpdateData = @json(old());
            updateCategory(oldUpdateData.category_id, '{{ route('admin.category.update', ['category' => old('category_id')]) }}');
            @endif

            @if(collect(old())->hasAny(['name', 'post_type', 'description']))
            const oldCreationData = @json(old());
            HamkkeJsHelpers.populateFormWithData(oldCreationData, 'categoryCreationForm');
            @endif
        });

    </script>
    <script src="{{ asset('cms-assets/js/pages/list-categories.js') }}"></script>
@endsection
