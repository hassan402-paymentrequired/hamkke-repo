<?php

namespace App\Livewire\Admin;

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class ProductsList extends Component
{
    use WithPagination;

    public Collection $productCategories;
    public array $productTypes;

    public User|Authenticatable $authUser;

    public function mount(): void
    {
        $this->authUser = auth()->user();
        $this->productCategories = ProductCategory::all();
        $this->productTypes = ProductType::cases();
    }

    public function render()
    {
        $products = Product::paginate(3);
        return view('livewire-components.admin.products-list', compact('products'));
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
