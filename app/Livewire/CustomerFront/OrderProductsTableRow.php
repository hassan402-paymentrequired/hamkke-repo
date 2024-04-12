<?php

namespace App\Livewire\CustomerFront;

use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderProductsTableRow extends Component
{
    public Product $orderProduct;

    public function mount(Product $orderProduct): void
    {
        $this->orderProduct = $orderProduct;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.order-products-table-row');
    }
}
