<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id'   => 'sometimes|required|exists:categories,id',
            'brand_id'      => 'nullable|exists:brands,id',
            'name'          => 'sometimes|required|string|max:255',
            'unit'          => 'sometimes|required|string',
            'price'         => 'sometimes|required|numeric|min:0',
            'description'   => 'nullable|string',
            'nutrition_info'=> 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Notification::error('Validasi gagal', 422, $validator->errors())
        );
    }
}
