<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'payment_method'  => 'required|string',
            'delivery_method' => 'nullable|string',
            'promo_code'      => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.string'   => 'Format metode pembayaran tidak valid.',
            'delivery_method.string'  => 'Format metode pengiriman tidak valid.',
            'promo_code.string'       => 'Format kode promo tidak valid.',
        ];
    }
}
