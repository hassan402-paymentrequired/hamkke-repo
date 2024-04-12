<?php

namespace App\Livewire\Forms\Admin;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class ProductForm extends Form
{
    public $productImage = null;
    public ?string $name;
    public ?string $description;
    public ?string $price;
    public ?int $productCategory = null;
    public ?int $productType = null;
    public $electronic_document;
    public ?string $class_registration_link = null;

    public ?Product $product = null;

    public function rules()
    {
        $nameRule = $this->product ? Rule::unique('products')->ignore($this->product->id)
            : Rule::unique('products');
        $imageRequired = $this->product && $this->product->product_image ? 'nullable' : 'required';

        if($this->product){
            $imageRequired = $this->product->product_image ? 'nullable' : 'required';
            $electronicDocRequired = $this->product->electronic_product_url ? ["nullable"] :
                ["required_if:productType," . ProductType::DIGITAL_PRODUCT->value, "nullable"];
            return [
                'productImage' => ['bail', $imageRequired, File::image()->types(['png', 'jpg', 'jpeg', 'svg'])
                    ->max('2mb')],
                'name' => $nameRule,
                'description' => ['required'],
                'price' => ['required', 'numeric', 'min:1', 'max:100000000'],
                'productCategory' => [Rule::exists('product_categories', 'id')],
                'productType' => ['required', Rule::in(ProductType::DIGITAL_PRODUCT->value, ProductType::LIVE_CLASSES->value)],
                'electronic_document' => [...$electronicDocRequired, File::types(['pdf', 'epub', 'doc', 'docx'])],
                'class_registration_link' => ['required_if:productType,'. ProductType::LIVE_CLASSES->value, 'nullable', 'url']
            ];
        }
        return [
            'productImage' => ['bail', $imageRequired, File::image()->types(['png', 'jpg', 'jpeg', 'svg'])
                ->max('2mb')],
            'name' => $nameRule,
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:1', 'max:100000000'],
            'productCategory' => [Rule::exists('product_categories', 'id')],
            'productType' => ['required', Rule::in(ProductType::DIGITAL_PRODUCT->value, ProductType::LIVE_CLASSES->value)],
            'electronic_document' => ['required_without:class_registration_link', 'nullable', File::types(['pdf', 'epub', 'doc', 'docx'])],
            'class_registration_link' => ['required_without:electronic_document', 'nullable', 'url']
        ];

    }

    /**
     * @throws ValidationException
     */
    public function store()
    {
        $this->validate();
        $this->slug = createSlugFromString($this->name);
        return Product::create([
            'product_image' => $this->uploadImage($this->productImage, 'product_images'),
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price * 100,
            'description' => $this->description,
            'product_type' => $this->productType,
            'product_category_id' => $this->productCategory,
            'electronic_product_url' => $this->uploadImage($this->electronic_document, 'electronic_product_documents') ?? $this->product->electronic_product_url,
            'class_registration_url' => $this->class_registration_link
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(): bool
    {
        $this->validate();
        $this->slug = createSlugFromString($this->name);
        return $this->product->update([
            'product_image' => $this->uploadImage($this->productImage, 'product_images') ?? $this->product->product_image,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price * 100,
            'description' => $this->description,
            'product_category_id' => $this->productCategory,
            'product_type' => $this->productType,
            'electronic_product_url' => $this->uploadImage($this->electronic_document, 'electronic_product_documents') ?? $this->product->electronic_product_url,
            'class_registration_url' => $this->class_registration_link
        ]);
    }

    private function uploadImage($fileInRequest, $folderName): ?string
    {
        if ($fileInRequest) {
            $filename = strtolower($this->slug) . time()
                . '.' . $fileInRequest->getClientOriginalExtension();
            $path = $fileInRequest->storeAs("/{$folderName}", $filename, ['disk' => 'public']);
            return getAbsoluteUrlFromPath($path);
        }
        return null;
    }


}
