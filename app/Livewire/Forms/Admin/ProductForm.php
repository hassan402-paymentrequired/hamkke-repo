<?php

namespace App\Livewire\Forms\Admin;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Validation\Rule;
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

    public ?string $slug = '';
    public ?string $productFilePath = null;

    public function rules()
    {
        $nameRule = $this->product
            ? Rule::unique('products')->ignore($this->product->id)
            : Rule::unique('products');

        $imageRequired = $this->product && $this->product->product_image ? 'nullable' : 'required';

        if ($this->product) {
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
                'productType' => ['required', Rule::in(ProductType::DIGITAL_PRODUCT->value, ProductType::LIVE_CLASSES->value, ProductType::PHYSICAL_PRODUCT->value)],
                'electronic_document' => [...$electronicDocRequired, File::types(['pdf', 'epub', 'doc', 'docx'])],
                'class_registration_link' => ['required_if:productType,' . ProductType::LIVE_CLASSES->value, 'nullable', 'url']
            ];
        }

        return [
            'productImage' => ['bail', $imageRequired, File::image()->types(['png', 'jpg', 'jpeg', 'svg'])
                ->max('2mb')],
            'name' => $nameRule,
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:1', 'max:100000000'],
            'productCategory' => [Rule::exists('product_categories', 'id')],
            'productType' => ['required', Rule::in(ProductType::DIGITAL_PRODUCT->value, ProductType::LIVE_CLASSES->value, ProductType::PHYSICAL_PRODUCT->value)],
            'electronic_document' => ['required_if:productType,' . ProductType::DIGITAL_PRODUCT->value, 'nullable', File::types(['pdf', 'epub', 'doc', 'docx'])],
            'class_registration_link' => ['required_if:productType,' . ProductType::LIVE_CLASSES->value, 'nullable', 'url']
        ];
    }

    public function messages()
    {
        return [
            'electronic_document.required_if' => 'Please upload an electronic document when the product type is digital.',
            'class_registration_link.required_if' => 'A registration link is required when the product type is live classes.',
        ];
    }


    /**
     * @throws ValidationException
     */
    public function store()
    {
        $this->validate();
        $this->slug = createSlugFromString($this->name);
        $this->productFilePath = Product::uploadProductDocument($this->electronic_document, $this->slug);
        return Product::create([
            'product_image' => $this->uploadImage($this->productImage),
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price * 100,
            'description' => $this->description,
            'product_type' => $this->productType,
            'product_category_id' => $this->productCategory,
            'electronic_product_file_path' => $this->productFilePath,
            'electronic_product_url' => $this->productFilePath ? getAbsoluteUrlFromPath($this->productFilePath) : null,
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
        if ($this->electronic_document) {
            $this->productFilePath = Product::uploadProductDocument($this->electronic_document, $this->slug);
        }
        return $this->product->update([
            'product_image' => $this->uploadImage($this->productImage) ?? $this->product->product_image,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price * 100,
            'description' => $this->description,
            'product_category_id' => $this->productCategory,
            'product_type' => $this->productType,
            'electronic_product_file_path' => $this->productFilePath ?? $this->product->electronic_product_file_path,
            'electronic_product_url' => $this->productFilePath ? getAbsoluteUrlFromPath($this->productFilePath) : $this->product->electronic_product_url,
            'class_registration_url' => $this->class_registration_link
        ]);
    }

    private function uploadImage($fileInRequest): ?string
    {
        if ($fileInRequest) {
            $filename = strtolower($this->slug) . time()
                . '.' . $fileInRequest->getClientOriginalExtension();
            $path = $fileInRequest->storeAs('/product_images', $filename, ['disk' => 'public']);
            return getAbsoluteUrlFromPath($path);
        }
        return null;
    }
}
