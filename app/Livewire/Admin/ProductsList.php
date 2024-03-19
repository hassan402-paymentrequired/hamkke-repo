<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Products')]
class ProductsList extends Component
{
    /**
     * @var Product[]|Collection $products
     */
    public array|Collection $products;

    public Collection $productCategories;

    public User|Authenticatable $authUser;

    public function mount(): void
    {
        $this->authUser = auth()->user();
        $this->products = Product::all();
        $this->productCategories = ProductCategory::all();
    }

    public function render()
    {
        return view('livewire-components.admin.products-list');
    }

    #[On('open-creation-modal')] public function openCreationModal(): void
    {
        $this->dispatch('open-modal');
    }
    #[On('close-creation-modal')] public function closeCreationModal(): void
    {
        $this->dispatch('close-modal');
    }

    public function createProduct(): void
    {
        $this->openCreationModal();
    }
}
