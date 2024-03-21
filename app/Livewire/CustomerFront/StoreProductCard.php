<?php

namespace App\Livewire\CustomerFront;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StoreProductCard extends Component
{
    public Product $product;

    public int $quantity;

    public function mount($product, $quantity): void
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * Renders the component on the browser.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.store-product-card');
    }

    public function addToCart(): void
    {
        $this->quantity++;
        $this->dispatch('add-to-cart', $this->product);
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
        $this->dispatch('increase-product-quantity', $this->product);
    }

    public function decreaseQuantity(): void
    {
        $this->quantity--;
        $this->dispatch('decrease-product-quantity', $this->product);
    }
}
