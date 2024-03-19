<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductsTableRow extends Component
{
    public Product $product;

    public function render()
    {
        return view('livewire-components.admin.products-table-row');
    }

    /**
     * @return void
     */
    #[NoReturn] #[On('delete-product')] public function deleteProduct($id): void
    {
        if(!auth()->user()->can('admin.product.delete')){
            $this->dispatch('show-toast', [
                'title' => 'Permission Denied!!',
                'message' => 'You are not permitted to delete products',
                'toast_type' => 'error'
            ]);
        } else {
//            TODO:: Please check if the product is currently attached to an order before deleting
            Product::where('id', $id)->delete();
            flashSuccessMessage('Product deleted successfully');
            $this->redirect(route('admin.products.list'));
        }

    }
}
