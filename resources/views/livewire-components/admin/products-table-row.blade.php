<tr>
    <td>#{{ $product->id }}</td>
    <td class="nk-tb-col">{{ $product->name }}</td>
    <td class="nk-tb-col"><span class="ti ti-currency-naira"></span>{{ $product->getPriceInNaira(true) }}</td>
    <td>0</td>
    <td class="nk-tb-col">
        @canany(['admin.product.update', 'admin.product.delete'])
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <div class="dropdown-menu">
                    @can('admin.product.update')
                        <a class="dropdown-item" href="javascript:void(0)" wire:click="$dispatch('update-product', { 'id': {{ $product->id }} });">
                            <i class="ti ti-pencil me-1"></i> Edit
                        </a>
                    @endcan
                    @can('admin.product.delete')
                        <a class="dropdown-item" href="javascript:void(0)" data-product-id="{{ $product->id }}"
                           id="deleteProduct_{{ $product->id }}">
                            <i class="ti ti-trash me-1"></i> Delete
                        </a>
                    @endcan
                </div>
            </div>
        @else
            ----
        @endcanany
    </td>
</tr>
