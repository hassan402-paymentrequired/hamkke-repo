<?php

namespace App\Livewire\Admin;

use App\Models\ProductCategory;
use Livewire\Component;

class ProductCategoriesTableRow extends Component
{
    public ProductCategory $category;

    public function render()
    {
        return view('livewire-components.admin.product-categories-table-row');
    }

    public function updateProductCategory()
    {

    }
}
