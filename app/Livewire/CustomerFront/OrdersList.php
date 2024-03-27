<?php

namespace App\Livewire\CustomerFront;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My orders')]
#[Layout('livewire-layouts.customer-front-layout')]
class OrdersList extends Component
{
    use WithPagination;

    /**
     * @return View
     */
    public function render(): View
    {
        $orders = Order::where('customer_id', auth(CUSTOMER_GUARD_NAME)->id())
            ->paginate();
        return view('livewire-components.customer-front.orders-list', compact('orders'));
    }
}
