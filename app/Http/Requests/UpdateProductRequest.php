<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'integer','min:1'],
            'is_active' => ['required', 'boolean'],
            'is_visible' => ['required', 'boolean'],
            'image' => ['nullable','image','max:2048'],
        ];
        return $rules;
    }

    public function messages(): array
    {
    return [
        'name.required' => '商品名は必須です',
        'name.max' => '商品名は30文字以内で入力してください',

        'price.required' => '価格を入力してください',
        'price.integer' => '価格は数字で入力してください',
        'price.min' => '価格は1以上で入力してください',

        'is_active.required' => '販売状態を選択してください',
        'is_active.boolean' => '販売状態の値が正しくありません',

        'is_visible.required' => '表示/非表示を選択してください',
        'is_visible.boolean' => '表示/非表示の値が正しくありません',

        'image.image' => '画像ファイルを選択してください',
        'image.max' => '画像サイズは2MB以下にしてください',
        ];
    }
}
