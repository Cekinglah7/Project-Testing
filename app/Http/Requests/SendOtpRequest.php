<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
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
            'telepon' => 'required|numeric|digits_between:10,15'
        ];
    }

    public function messages(): array
    {
        return [
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.numeric'  => 'Nomor telepon harus berupa angka.',
            'telepon.digits_between' => 'Nomor telepon harus di antara 10 sampai 15 digit.',
        ];
    }
}
