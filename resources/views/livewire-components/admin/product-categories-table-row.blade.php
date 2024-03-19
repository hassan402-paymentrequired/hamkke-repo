<tr>
    <td>#{{ $category->id }}</td>
    <td>
        @if($category->navigation_icon)
            <img src="{{ $category->navigation_icon }}" style="max-height: 50px;" alt="{{ $category->name }} navigation icon" />
        @else
            ---
        @endif
    </td>
    <td class="nk-tb-col">{{ $category->name }}</td>
    <td class="nk-tb-col">
        @canany(['admin.product-category.update', 'admin.product-category.delete'])
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <div class="dropdown-menu">
                    @can('admin.product-category.update')
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="ti ti-pencil me-1"></i> Edit
                        </a>
                    @endcan
                    @can('admin.product-category.delete')
                        <a class="dropdown-item" href="javascript:void(0)">
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
