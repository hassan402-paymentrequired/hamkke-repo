<?php

namespace App\Livewire\Admin;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Categories')]
class ProductCategoriesList extends Component
{
    public Collection $productCategories;
//    public bool $showCreationModal = false;

    public User|Authenticatable $authUser;

    public function mount()
    {
        $this->authUser = auth()->user();
        $this->productCategories = ProductCategory::all();
    }

    public function render()
    {
        return view('livewire-components.admin.product-categories-list');
    }

    #[On('open-creation-modal')] public function openCreationModal(): void
    {
//        $this->showCreationModal = true;
        $this->dispatch('open-modal');
    }
    #[On('close-creation-modal')] public function closeCreationModal(): void
    {
        $this->dispatch('close-modal');
//        $this->showCreationModal = false;
    }

    public function createProductCategory(): void
    {
        $this->openCreationModal();
    }
}
