<x-admin.modal modalId="productCategoryCreationModal" modalTitle="Create Product Category">
    <form wire:submit.prevent="save" method="POST" enctype="multipart/form-data"
          id="productCategoryCreationForm">
        @csrf
        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
            <img src="@if($form->navigationIcon) {{ $form->navigationIcon->temporaryUrl() }} @else {{ asset('images/avatar-placeholder-640.png') }} @endif"
                 alt="Category Navigation Icon" class="d-block w-px-100 h-px-100 rounded"
                 id="uploadedNavigationIcon"/>
            <div class="button-wrapper">
                <label for="navigationIcon" class="btn btn-primary me-2 mb-3"
                       tabindex="0">
                    <span class="d-none d-sm-block">Upload Navigation Icon</span>
                    <em class="ti ti-upload d-block d-sm-none"></em>
                    <input type="file" id="navigationIcon" hidden
                           accept="image/png, image/jpeg"
                           wire:model.live="form.navigationIcon"/>
                </label>
                <button type="button" id="resetNavigationIcon"
                        class="btn btn-label-secondary mb-3">
                    <em class="ti ti-refresh-dot d-block./.. d-sm-none"></em>
                    <span class="d-none d-sm-block">Reset</span>
                </button>
                <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
            </div>
        </div>
        @error('form.navigationIcon')
        <div><span class="help-block form-error" role="alert">{{ $message }}</span><br></div>
        @enderror
        <hr class="my-0"/>
        <div class="row">
            <div class="col mb-3">
                <label for="productCategoryName" class="form-label">Name</label>
                <input type="text" id="productCategoryName" wire:model="form.name"
                       class="form-control" placeholder="Product Category Name"/>
                <div>
                    @error('form.name') <span class="help-block form-error" role="alert">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" wire:model="form.description" class="form-control"
                          placeholder="Product Category Description"></textarea>
                <div>
                    @error('form.description') <span class="help-block form-error"
                                                     role="alert">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer px-0 py-1">
            <button type="button" class="btn btn-label-secondary"
                    wire:click="closeModal">Close
            </button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</x-admin.modal>
