<div>
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">eCommerce /</span>Products
    </h4>
    <div class="card">
{{--        <h5 class="card-header">Products List</h5>--}}
        <div class="card-body">
            @can('admin.product.create')
                <div class="row">
                    <div class="col-md-2 offset-md-10 mb-3 mt-1">
                        <button class="btn btn-primary w-100" type="button" wire:click="$dispatch('create-product')">
                            Add Product
                        </button>
                    </div>
                </div>
            @endcan
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered permissions-management-table">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Purchased</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $n = 0; ?>
                    @foreach($products as $product)
                        <livewire:admin.products-table-row :key="$product->id" :product="$product">
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <livewire:admin.create-product key="productCreationModal" :productCategories="$productCategories" :productTypes="$productTypes"/>
</div>

<x-slot name="more_scripts_slot">
    @script
    <script>
        const {addLivewireEventListener, uploadAndPreviewImage} = HamkkeJsHelpers;
        addLivewireEventListener( function () {
            uploadAndPreviewImage('#uploadedProductImage', '#productImage', '#resetProductImage');
            const deleteProductLinks = document.querySelectorAll("[id^='deleteProduct_']")
        });
        $wire.on('show-toast', (event) => {
            const eventParams = event[0]
            HamkkeJsHelpers.showToast(eventParams.title, eventParams.message, eventParams.toast_type)
        });
        $wire.on('close-modal', () => {
            $('#productCreationModal').modal('hide');
        });
        $wire.on('open-modal', () => {
            $('#productCreationModal').modal('show');
        });
        $("[id^=deleteProduct_]").on('click', e => {
            HamkkeJsHelpers.confirmationAlert('This action cannot be reversed')
                .then(confirmed => {
                    if(confirmed) {
                        const productId = $(e.target).data('productId');
                        $wire.dispatch('delete-product', {id: productId});
                    }
                })
        })
    </script>
    @endscript
</x-slot>


