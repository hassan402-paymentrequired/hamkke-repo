<?php

namespace App\Livewire\CustomerFront;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class OrdersListItem extends Component
{

    public Order $order;

    /**
     * @param Order $order
     * @return void
     */
    public function mount(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return View
     */
    public function render() : View
    {
        return view('livewire-components.customer-front.orders-list-item');
    }
}
