@php use App\Enums\ProductType; @endphp
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
                    <span class="d-none d-sm-block">Upload Product Image <span class="text-white">*</span> </span>
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
        <hr class="my-3"/>
        <div class="row">
            <div class="col mb-3">
                @if($this->productTypeEditable())
                    <label for="productType" class="form-label">Product Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="productType" wire:model.live="form.productType"
                            aria-label="Post Tye Selection">
                        <option value="">Select Product Type</option>
                        @foreach($productTypes as $pT)
                            <option :key="$pT->value" value="{{ $pT->value }}">
                                {{ $pT->displayName() }}
                            </option>
                        @endforeach
                    </select>
                    @error('form.productType')
                    <div>
                        <span class="help-block form-error" role="alert">{{ $message }}</span>
                    </div>
                    @enderror
                @else
                    <p>
                        <span style="font-weight: bold">Product Type :: {{ $form->product->product_type->displayName() }}</span>
                        <br>
                        <span class="text-decoration-underline">Product::</span>
                        <a href="{{ $this->getProductDocument() }}" target="_blank">
                            {{ $this->getProductDocument(true) }}
                        </a>
                    </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="productCategory" class="form-label">Product Category <span
                        class="text-danger">*</span></label>
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
        <div class="row">
            <div class="col mb-3">
                <label for="productName" class="form-label">Name <span class="text-danger">*</span></label>
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
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
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
                <label for="productPrice" class="form-label">Price <span class="text-danger">*</span></label>
                <input type="number" id="productPrice" wire:model="form.price"
                       class="form-control" placeholder="Price in naira"/>
                @error('form.price')
                <div>
                    <span class="help-block form-error" role="alert">{{ $message }}</span>
                </div>
                @enderror
            </div>
        </div>
        @if($this->productTypeEditable())
            @if($form->productType == ProductType::DIGITAL_PRODUCT->value)
            <div class="row">
                <div class="col mb-3">
                    <span>Upload the document to be share to the customer when an order is successful</span>
                    <br>
                    <label for="electronicDocument" class="btn btn-primary me-2 mb-3"
                           tabindex="0">
                        <span class="d-none d-sm-block">Upload The Product <span class="text-danger">*</span></span>
                        <em class="ti ti-upload d-block d-sm-none"></em>
                        <input type="file" id="electronicDocument" hidden
                               wire:model.live="form.electronic_document"/>
                    </label>
                    <br>
                    <div wire:loading wire:target="form.electronic_document">Uploading...</div>
                    @error('form.electronic_document')
                    <div>
                        <span class="help-block form-error" role="alert">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
            @elseif($form->productType == ProductType::LIVE_CLASSES->value)
                <div class="row">
                    <div class="col mb-3">
                        <label for="registrationUrl" class="form-label">Class registration url <span
                                class="text-danger">*</span></label>
                        <input type="url" id="registrationUrl" wire:model="form.class_registration_link"
                               class="form-control" placeholder="Google doc link"/>
                        @error('form.class_registration_link')
                        <div>
                            <span class="help-block form-error" role="alert">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                </div>
            @endif
        @endif


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



        <div class="modal-footer px-0 py-1">
            <button type="button" class="btn btn-label-secondary"
                    wire:click="closeModal">Close
            </button>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Submit</button>
        </div>
    </form>
</x-admin.modal>


