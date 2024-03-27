<?php

namespace App\Livewire\CustomerFront;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderProductsTableRow extends Component
{
    public Product $orderProduct;

    public function mount(Product $orderProduct): void
    {
        $this->orderProduct = $orderProduct;
    }

    public function getUnitPrice(): string
    {
        return number_format($this->orderProduct->price/100, 2);
    }

    public function getTotalPrice(): string
    {
        return number_format(
            $this->orderProduct->price * $this->orderProduct->pivot->quantity/100, 2
        );
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.order-products-table-row');
    }
}
