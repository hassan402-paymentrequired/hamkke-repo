<?php

namespace App\Livewire\CustomerFront;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Details')]
#[Layout('livewire-layouts.customer-front-layout')]
class ViewOrder extends Component
{
    public Order|string $order;

    /**
     * @var Product[] $orderProducts
     */
    public array|Collection $orderProducts;

    /**
     * @param string|Order $order
     * @return void
     */
    public function mount(Order|string $order) : void
    {
        if($order instanceof Order) {
            $this->order = $order;
        } else {
            if(is_numeric($order)){
                $this->order = Order::find($order);
            } else {
                $orderId = encryptDecrypt('decrypt', urldecode($order));
                $this->order = Order::find($orderId);
            }
        }
        $this->orderProducts =  $this->order->products()->withTrashed()->get();
    }

    /**
     * @return View
     */
    public function render() : View
    {
        return view('livewire-components.customer-front.view-order');
    }
}
