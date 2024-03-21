<?php

namespace App\Livewire\CustomerFront;

use App\Facades\Cart;
use App\Helpers\CartProductItem;
use Illuminate\View\View;
use Livewire\Component;

class CartProduct extends Component
{
    /**
     * @var CartProductItem
     */
    public CartProductItem $cartProductItem;

    public int $productId;
    public int $quantity;
    public int|float|string $amount;

    public function mount(CartProductItem $cartProductItem): void
    {
        $this->cartProductItem = $cartProductItem;
        $this->productId = $this->cartProductItem->product_id;
        $this->quantity = $this->cartProductItem->quantity;
        $this->amount = $this->cartProductItem->amountInNaira();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.cart-product');
    }

    public function updateItem($init = false): void
    {
        $this->cartProductItem = Cart::getItemFromCart($this->productId);
        $this->amount = $this->cartProductItem->amountInNaira();
        $this->dispatch('cart-updated');
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
        Cart::updateCart($this->cartProductItem->toLivewire(), $this->quantity);
        $this->updateItem();
    }

    public function decreaseQuantity(): void
    {
        if ($this->quantity == 1) {
            $this->removeFromCart();
        } else {
            $this->quantity--;
            Cart::updateCart($this->cartProductItem->toLivewire(), $this->quantity);
            $this->updateItem();
        }
    }

    public function removeFromCart(): void
    {
        Cart::removeFromCart($this->productId);
        $this->dispatch('cart-updated');
    }
}
