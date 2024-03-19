<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\ProductCategoryForm;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProductCategory extends Component
{
    use WithFileUploads;
    public ProductCategoryForm $form;

    public function openModal(): void
    {
        $this->dispatch('open-creation-modal');
    }
    public function closeModal(): void
    {
        $this->dispatch('close-creation-modal');
    }

    /**
     * @return void
     * @throws ValidationException
     */
    #[NoReturn] public function save(): void
    {
        $productCategory = $this->form->store();

        $this->dispatch('product-category-created', $productCategory)->to(ProductCategoriesList::class);

        flashSuccessMessage( 'Product Category "'. $productCategory['name']. '" created successfully');
        $this->redirect(route('admin.product-categories.list'));
    }

    public function render()
    {
        return view('livewire-components.admin.create-product-category');
    }


}
