<?php

namespace App\Http\Requests;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateOrCreateCategory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(isCurrentRoute('admin.category.update')){
            $category = $this->route('category');
            return [
                'edit_category_navigation_icon' => ['nullable', File::image()->types(['png', 'jpg', 'jpeg'])->min('2kb')->max('2mb')],
                'edit_category_name' => ['required', Rule::unique('post_categories','name')->ignore($category)
                    ->whereNull('deleted_at')],
                'edit_category_post_type' => ['required', 'exists:post_types,id'],
                'edit_category_description' => 'required'
            ];
        }
        return [
            'navigation_icon' => ['nullable', File::image()->types(['png', 'jpg', 'jpeg'])->min('2kb')->max('2mb')],
            'name' => ['required', Rule::unique('post_categories','name')],
            'post_type' => ['required', 'exists:post_types,id'],
            'description' => 'required'
        ];
    }

    public function attributes()
    {
        if(isCurrentRoute('admin.category.update')){
            return [
                'edit_category_navigation_icon' => 'navigation_icon',
                'edit_category_name' => 'name',
                'edit_category_post_type' => 'post_type',
                'edit_category_description' => 'description'
            ];
        }
        return parent::attributes();
    }
}
