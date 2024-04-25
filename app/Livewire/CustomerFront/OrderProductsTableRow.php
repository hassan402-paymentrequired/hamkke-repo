<?php

namespace App\Livewire\CustomerFront;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderProductsTableRow extends Component
{
    public Order $order;
    public Product $orderProduct;

    public function mount(Order $order, Product $orderProduct): void
    {
        $this->order = $order;
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
