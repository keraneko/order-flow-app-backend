<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderCustomerRequest extends FormRequest
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
            'phone' => ['required', 'string', 'max:11', 'min:10' ,'regex:/^[0-9]+$/'],
            'address' =>['nullable', 'string', 'max:255'], 
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は30文字以内で入力してください',

            'phone.required' => '電話番号を入力してください',
            'phone.min' => '電話番号は10桁以上11桁以内で入力してください',
            'phone.max' => '電話番号は10桁以上11桁以内で入力してください',
            'phone.regex' => '電話番号は半角数字のみで入力してください',

            'address.max' => '住所は255文字以内で入力してください',
        ];
    }
}
