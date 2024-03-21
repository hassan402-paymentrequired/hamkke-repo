<?php

namespace App\Livewire\CustomerFront;

use App\Facades\Cart;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Hamkke Store')]
#[Layout('livewire-layouts.customer-front-layout')]
class Store extends Component
{
    public array|Collection $products;

    public array|Collection $productCategories;

    #[Url]
    public ?string $category = '';
    public array $productsInCart = [];
    public array $cartItemQuantities = [];

    public ?ProductCategory $currentProductCategory = null;

    public function mount() : void
    {
        if($this->category){
            $this->currentProductCategory = ProductCategory::where('slug', $this->category)->first();
        }
        if($this->currentProductCategory){
            $this->products = Product::where('product_category_id', $this->currentProductCategory->id)->get();
        } else {
            $this->category = '';
            $this->products = Product::all();
        }
        $this->category = $this->currentProductCategory ? $this->category : '';
        $this->productCategories = ProductCategory::all();
        $this->updateMainCart();
    }

    #[NoReturn] public function updateMainCart(): void
    {
        $this->cartItemQuantities = Cart::getItemQuantityMap();
        // Generate new array with keys set to true
        $newArray = array_map(function($key) {
            return [$key => true];
        }, array_keys($this->cartItemQuantities));

        $this->productsInCart = array_merge(...$newArray);
        $this->dispatch('cart-updated');
    }

    #[NoReturn] #[On('add-to-cart')] public function addToCart($product): void
    {
        $quantity = $this->cartItemQuantities[$product['id']] ?? 1;
        Cart::addToCart($product, $quantity);
        $this->updateMainCart();
    }

    #[NoReturn] #[On('increase-product-quantity')] public function increaseQuantity($product): void
    {
        $productId = $product['id'];
        Cart::updateCart($product, $this->cartItemQuantities[$productId] + 1);
        $this->updateMainCart();
    }

    #[NoReturn] #[On('decrease-product-quantity')] public function decreaseQuantity($product): void
    {
        $productId = $product['id'];
        $currentQuantity = $this->cartItemQuantities[$productId] ?? 0;
        $newQuantity = $currentQuantity - 1;
        if($newQuantity < 1){
            Cart::removeFromCart($productId);
        } else {
            Cart::updateCart($product, $newQuantity);
        }
        $this->updateMainCart();
    }

    public function render()
    {
        return view('livewire-components.customer-front.store');
    }
}
