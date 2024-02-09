<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (isCurrentRoute('admin.tag.update')) {
            $tag = $this->route('tag');
            return [
                'edit_tag_name' => ['required', Rule::unique('tags', 'name')->ignore($tag)
                    ->whereNull('deleted_at')]
            ];
        }
        return [
            'name' => 'required|unique:tags,name|min:5|max:255'
        ];
    }
}
