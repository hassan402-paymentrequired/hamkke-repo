<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateOrCreateUser extends FormRequest
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
        return [
            'user_avatar' => ['nullable', File::image()->types(['jpg', 'jpeg'])->min('2kb')->max('2mb')],
            'name' => 'required|string|max:250',
            'email' => 'required|unique:users,email',
            'role' => 'required|exists:roles,id',
            'author_bio' => 'nullable'
        ];
    }
}
