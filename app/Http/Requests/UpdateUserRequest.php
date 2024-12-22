<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'      => 'string|max:255',
            'email'     => 'string|email|max:255|unique:users,email,' . $this->user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'file_id'   => 'nullable|exists:files,id',
            'old_password' => 'required|string|min:8',
        ];
    }
}