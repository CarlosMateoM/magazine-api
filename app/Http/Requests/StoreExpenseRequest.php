<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'fixed_expense_id'      => 'nullable|exists:fixed_expenses,id',
            'expense_category_id'   => 'required|exists:expense_categories,id',
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string|max:1000',
            'amount'                => 'required|numeric|min:0',
        ];
    }
}
