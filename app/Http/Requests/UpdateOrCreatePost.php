<?php

namespace App\Http\Requests;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Pest\Laravel\post;

class UpdateOrCreatePost extends FormRequest
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
        if(!$this->isMethod('POST')){
            return [];
        }
        if(isCurrentRoute('admin.post.update')){
            $post = $this->route('post');
            return [
                'post_title' => ['required', Rule::unique('posts','title')->ignore($post)
                    ->whereNull('deleted_at')],
                'post_type' => ['required', 'exists:post_types,id'],
                'post_category' => ['required', 'exists:categories,id'],
                'post_summary' => 'required',
                'post_content' => ['required'],
                'post_status' => ['required', Rule::in(PostStatus::getValues())],
                'post_tags' => ['nullable', 'array', 'max:3'],
                'post_tags.*' => ['required', 'exists:tags,id']
            ];
        }
        return [
            'post_title' => ['required', Rule::unique('posts','title')->whereNull('deleted_at')],
            'post_type' => ['required', 'exists:post_types,id'],
            'post_category' => ['required', 'exists:categories,id'],
            'post_summary' => 'required',
            'post_content' => ['required'],
            'post_tags' => ['nullable', 'array', 'max:3'],
            'post_tags.*' => ['required', 'exists:tags,id']

        ];
    }
}
