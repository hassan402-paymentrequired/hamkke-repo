<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumPostCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('web')->check() || auth(CUSTOMER_GUARD_NAME)->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'topic' => 'required|unique:forum_posts',
            'tags' => 'required|array|max:3',
            'tags.*' => 'required|exists:tags,id',
            'body' => 'required'
        ];
    }
}
