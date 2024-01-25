<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends FormRequest
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
        if($this->get('registration_request') == 'yes') {
            return [
                'comment' => ['required', 'string', 'max:200'],
                'username' => ['nullable', 'unique:customers'],
                'email' => ['required', 'unique:customers'],
                'register_password' => 'required|confirmed|min:7|max:255',
                'subscribe' => ['nullable']
            ];
        }
        if($this->get('login_request') == 'yes') {
            return [
                'comment' => ['required', 'string', 'max:200'],
                'email' => ['required', 'exists:customers'],
                'password' => 'required'
            ];
        }
        return [
            'comment' => ['required', 'string', 'max:200']
        ];
    }

}
