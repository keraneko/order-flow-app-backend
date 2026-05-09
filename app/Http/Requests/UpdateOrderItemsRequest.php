<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemsRequest extends FormRequest
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
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required','integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer' ,'min:1'],
        ];
        return $rules;
        
    }

    public function messages(): array
    {
        return [
            'items.required' => '商品を1つ以上選択してください',
            'items.array' => '商品の指定形式が正しくありません',
            'items.min' => '商品を1つ以上選択してください',

            'items.*.product_id.required' => '商品を選択してください',
            'items.*.product_id.integer' => '商品の値が正しくありません',
            'items.*.product_id.exists' => '選択された商品が存在しません',

            'items.*.quantity.required' => '数量を入力してください',
            'items.*.quantity.integer' => '数量は整数で入力してください',
            'items.*.quantity.min' => '数量は1以上で入力してください',
        ];
    }
}
