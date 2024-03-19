<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    public $productImage = null;
    public string $name;
    public string $description;
    public string|int $price;
    public int $productCategory;

    public ?Product $product = null;

    public function rules()
    {
        $nameRule = $this->product ? Rule::unique('products')->ignore($this->product->id)
            : Rule::unique('products');
        $imageRequired = $this->product && $this->product->product_image ? 'nullable' : 'required';
//        dd([$imageRequired]);
        return [
            'productImage' => ['bail', $imageRequired, File::image()->types(['png', 'jpg', 'jpeg', 'svg'])
                ->max('2mb')],
            'name' => $nameRule,
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:1', 'max:100000000'],
            'productCategory' => [Rule::exists('product_categories', 'id')]
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
            'product_image' => $this->uploadProductImage(),
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price * 100,
            'description' => $this->description,
            'product_category_id' => $this->productCategory
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
            'product_image' => $this->uploadProductImage() ?? $this->product->product_image,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price * 100,
            'description' => $this->description,
            'product_category_id' => $this->productCategory
        ]);
    }

    private function uploadProductImage(): ?string
    {
        if ($this->productImage) {
            $filename = strtolower("{$this->slug}_prd_img") . time()
                . '.' . $this->productImage->getClientOriginalExtension();
            $path = $this->productImage->storeAs('/product_images', $filename, ['disk' => 'public']);
            return getAbsoluteUrlFromPath($path);
        }
        return null;
    }


}
