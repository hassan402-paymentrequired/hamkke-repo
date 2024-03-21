<?php

namespace App\Livewire\CustomerFront;

use App\Facades\Cart;
use App\Helpers\CartProductItem;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart')]
#[Layout('livewire-layouts.customer-front-layout')]
class CartComponent extends Component
{
    /**
     * @var CartProductItem[]
     */
    public array $cartProducts;
    public int|float|string $totalAmount;

    public function mount(): void
    {
        $this->updateComponent();
    }

    #[On('cart-updated')] public function updateComponent(): void
    {
        $this->cartProducts = Cart::all();
        $sum = array_sum(
            array_map(function (CartProductItem $cartProduct) {
                return $cartProduct->price * $cartProduct->quantity;
            }, $this->cartProducts)
        );
        $this->totalAmount = number_format($sum/100);
    }
    /**
     * Renders the component on the browser.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.cart-component');
    }
}
