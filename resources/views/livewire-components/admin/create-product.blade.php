<x-admin.modal modalId="productCreationModal" modalTitle="{{ $modalTitle ?? 'Create Product' }}">
    <form wire:submit.prevent="save" method="POST" enctype="multipart/form-data"
          id="productCreationForm">
        @csrf

        <img
            src="{{ $this->getProductImage() ?? asset('frontend-assets/placeholder-image_large.webp') }}"
            alt="Product Image" class="d-block h-px-200 rounded"
            id="uploadedProductImage"/>
        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3 mt-3">
            <div class="button-wrapper">
                <label for="productImage" class="btn btn-primary me-2 mb-3"
                       tabindex="0">
                    <span class="d-none d-sm-block">Upload Product Image</span>
                    <em class="ti ti-upload d-block d-sm-none"></em>
                    <input type="file" id="productImage" hidden
                           accept="image/png, image/jpeg"
                           wire:model.live="form.productImage"/>
                </label>
                <button type="button" id="resetProductImage"
                        class="btn btn-label-secondary mb-3">
                    <em class="ti ti-refresh-dot d-block d-sm-none"></em>
                    <span class="d-none d-sm-block">Reset</span>
                </button>
                <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
            </div>
        </div>
        @error('form.productImage')
        <div><span class="help-block form-error" role="alert">{{ $message }}</span><br></div>
        @enderror
        <hr class="my-0"/>
        <div class="row">
            <div class="col mb-3">
                <label for="productName" class="form-label">Name</label>
                <input type="text" id="productName" wire:model="form.name"
                       class="form-control" placeholder="Product Name"/>
                @error('form.name')
                <div>
                    <span class="help-block form-error" role="alert">{{ $message }}</span>
                </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" wire:model="form.description" class="form-control"
                          placeholder="Product Category Description"></textarea>
                @error('form.description')
                <div>
                    <span class="help-block form-error" role="alert">{{ $message }}</span>
                </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="productPrice" class="form-label">Price</label>
                <input type="number" id="productPrice" wire:model="form.price"
                       class="form-control" placeholder="Price in naira"/>
                @error('form.price')
                <div>
                    <span class="help-block form-error" role="alert">{{ $message }}</span>
                </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="productCategory" class="form-label">Product Category</label>
                <select class="form-select" id="productCategory" wire:model="form.productCategory"
                        aria-label="Post Category Selection">
                    <option value="">Select Product Category</option>
                    @foreach($productCategories as $category)
                        <option :key="$category->id" value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('form.productCategory')
                <div>
                    <span class="help-block form-error" role="alert">{{ $message }}</span>
                </div>
                @enderror
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
