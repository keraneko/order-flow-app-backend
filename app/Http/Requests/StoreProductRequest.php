<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [
            'name' => ['required','string', 'max:30'],
            'price' => ['required','integer','min:1'],
            'is_active' => ['sometimes','boolean'],
            'is_visible' => ['sometimes', 'boolean'],
            'image' => ['nullable','image','max:2048'],
        ];
        return $rules;
    }

    public function messages(): array
    {
        return  [
            'name.required' => '商品名は必須です',
            'price.integer' => '価格は数字で入力してください',
            'price.min' => '価格は１以上にしてください',
        ];
    }
}
