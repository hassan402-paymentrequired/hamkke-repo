<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Order;
use App\Services\OrderService;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Details')]
class OrderDetails extends Component
{
    public Order $order;
    public Customer $orderCustomer;

    public $orderProducts;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->orderCustomer = $order->customer;
        $this->orderProducts = $this->order->products;
    }

    public function render()
    {
        return view('livewire-components.admin.order-details');
    }

    public function verifyTransaction()
    {
        $paymentTransactions = $this->order->payment_transactions;
        foreach ($paymentTransactions as $transaction){

        }
    }
}
