<div>
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">eCommerce /</span> Product Categories
    </h4>

    <!-- Bordered Table -->
    <div class="card">
{{--        <h5 class="card-header">Product Categories List</h5>--}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 offset-md-10 mb-3 mt-3">
                    <button class="btn btn-primary w-100" type="button" wire:click="createProductCategory">
                        Add Product Category
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered permissions-management-table">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n = 0; ?>
                    @foreach($productCategories as $category)
                        <livewire:admin.product-categories-table-row :key="$category->id" :category="$category">
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <livewire:admin.create-product-category key="productCategoryCreationModal" />
</div>

<x-slot name="more_scripts_slot">
    @script
    <script>
        $wire.on('show-toast', (event) => {
            const eventParams = event[0]
            HamkkeJsHelpers.showToast(eventParams.title, eventParams.message, eventParams.toast_type)
        });
        $wire.on('close-modal', (event) => {
            const eventParams = event[0]
            console.log({eventParams});
            $('#productCategoryCreationModal').modal('hide');
        });
        $wire.on('open-modal', (event) => {
            const eventParams = event[0]
            console.log({eventParams});
            $('#productCategoryCreationModal').modal('show');
        });
        const {addLivewireEventListener, uploadAndPreviewImage} = HamkkeJsHelpers;
        addLivewireEventListener( function () {
            uploadAndPreviewImage('#uploadedNavigationIcon', '#navigationIcon', '#resetNavigationIcon');
        } );
    </script>
    @endscript
</x-slot>


