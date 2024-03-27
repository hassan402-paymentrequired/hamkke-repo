<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    public ProductForm $form;

    public string $modalTitle = '';

    public array|Collection $productCategories;
    public array $productTypes;

    public function render()
    {
        return view('livewire-components.admin.create-product');
    }

    public function getProductImage(): ?string
    {
        if($this->form->productImage){
            return $this->form->productImage->temporaryUrl();
        } elseif ($this->form->product){
            return $this->form->product->product_image;
        }
        return null;
    }

    public function getProductType()
    {
        return $this->form->productType;
    }

    public function openModal(): void
    {
        $this->dispatch('open-creation-modal');
    }

    public function closeModal(): void
    {
        $this->dispatch('close-creation-modal');
    }

    public function getProductDocument($fileNameOnly = false): ?string
    {
        $product = $this->form->product;
        if($product){
            $productUrl = $product->electronic_product_url ?? $product->class_registration_url;
            return $fileNameOnly ? $productUrl : basename($productUrl);
        }
        return null;
    }

    /**
     * @return bool
     */
    public function productTypeEditable() : bool
    {
        return !$this->form->product || $this->form->product->orders()->count() === 0;
    }

    /**
     * @throws ValidationException
     */
    #[NoReturn] public function save(): void
    {
        if($this->form->product){
            $this->update();
        } else {
            $product = $this->form->store();

            flashSuccessMessage('Product "' . $product['name'] . '" created successfully');
            $this->redirect(route('admin.products.list'));
        }
    }

    /**
     * @throws ValidationException
     */
    #[NoReturn] public function update(): void
    {
        if(!auth()->user()->can('admin.product.update')) {
            $this->dispatch('show-toast', [
                'title' => 'Permission Denied!!',
                'message' => 'You are not permitted to update a product',
                'toast_type' => 'error'
            ]);
        } else {
            $this->form->update();
            flashSuccessMessage('Product updated successfully');
            $this->redirect(route('admin.products.list'));
        }
    }

    #[NoReturn] #[On('update-product')] public function editProduct($id): void
    {
        /**
         * @var Product $product
         */
        if(!auth()->user()->can('admin.product.update')){
            $this->dispatch('show-toast', [
                'title' => 'Permission Denied!!',
                'message' => 'You are not permitted to perform this action',
                'toast_type' => 'error'
            ]);
        } else {
            $product = Product::findOrFail($id);
            $this->modalTitle = 'Update Product: ' . $product->name;
            $this->form->fill([
                'product' => $product,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price / 100,
                'productCategory' => $product->product_category_id,
                'productType' => $product->product_type->value,
                'class_registration_link' => $product->class_registration_url,
            ]);
            $this->openModal();
        }
    }
    #[NoReturn] #[On('create-product')] public function createProduct(): void
    {
        $this->modalTitle = 'Add New Product';
        $this->form->reset();
        $this->openModal();
    }

}
