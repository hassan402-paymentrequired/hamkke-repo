<?php

namespace App\Livewire\CustomerFront;

use App\Facades\Cart;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CartButton extends Component
{
    public int $cartItemsQuantity;

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.cart-button');
    }

    #[On('cart-updated')] public function updateCart(): void
    {
        $this->cartItemsQuantity = Cart::getCartItemCount();
    }
}
