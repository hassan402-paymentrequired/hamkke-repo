<?php

namespace App\Livewire\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Orders')]
class OrdersList extends Component
{
    use WithPagination;

    public int $pendingOrders;
    public int $completedOrders;
    public int $canceledOrders;
    public int $failedOrders;

    public function mount()
    {

        /**
         * @var Collection $ordersSummary
         */
        $ordersSummary = Order::groupBy('order_status')->select(['order_status', DB::raw('count(order_status) as orders_count')])->get();
        $this->pendingOrders = $ordersSummary->where('order_status', OrderStatus::PENDING->value)->sum('orders_count');
        $this->completedOrders = $ordersSummary->where('order_status', OrderStatus::COMPLETED->value)->sum('orders_count');
        $this->canceledOrders = $ordersSummary->where('order_status', OrderStatus::CANCELED->value)->sum('orders_count');
        $this->failedOrders = $ordersSummary->where('order_status', OrderStatus::FAILED)->sum('order_count');
    }
    public function render(): View
    {
        $orders = Order::latest()->paginate(10);
        return view('livewire-components.admin.orders-list', compact('orders'));
    }
}
