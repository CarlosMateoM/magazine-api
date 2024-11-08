<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'biography' => 'string',
            'password' => 'required|string|min:8|confirmed',
            'is_public_author' => 'boolean',
            'is_locked_account' => 'boolean',
            'file.id' => 'required|exists:files,id',
            'role.id' => 'required|exists:roles,id',
        ];
    }
}
