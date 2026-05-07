<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'ID Produk wajib diisi.',
            'product_id.exists'   => 'Produk tidak ditemukan di database.',
            'quantity.min'        => 'Kuantitas minimal adalah 1.'
        ];
    }
}
