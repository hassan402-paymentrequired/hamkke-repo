<?php

namespace App\Livewire\Forms\Admin;

use App\Models\ProductCategory;
use Illuminate\Validation\Rules\File;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\Rule;

class ProductCategoryForm extends Form
{
    public ?ProductCategory $productCategory = null;

//    #[Validate('image|max:2048')]
    public $navigationIcon;

    public string $name;

    public string $slug;

    public string $description;

    public function rules(): array
    {
        $rule = $this->productCategory ?  Rule::unique('product_categories') :
            Rule::unique('product_categories')->ignore($this->productCategory);
        return [
            'navigationIcon' => ['nullable', File::image()->types(['png', 'jpg', 'jpeg', 'svg'])
                ->max('2mb')],
            'name' => [
                'required',
                $rule
            ],
            'description' => 'required|min:5',
        ];
    }

    /**
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(): mixed
    {
        $this->validate();
        $this->slug = createSlugFromString($this->name);
        return ProductCategory::create([
            'navigation_icon' => $this->uploadNavigationIcon(),
            'name' => $this->name,
            'slug' =>  $this->slug,
            'description' => $this->description
        ]);
    }

    /**
     * @return void
     */
    #[NoReturn] public function update(): void
    {
        dd($this->all());
    }

    public function uploadNavigationIcon(): ?string
    {
        if ($this->navigationIcon) {
            $filename = strtolower("{$this->slug}_nav_icon") . time()
                . '.' . $this->navigationIcon->getClientOriginalExtension();
            $path = $this->navigationIcon->storeAs('/navigation_icons', $filename, ['disk' => 'public']);
            return getAbsoluteUrlFromPath($path);
        }
        return null;
    }
}
