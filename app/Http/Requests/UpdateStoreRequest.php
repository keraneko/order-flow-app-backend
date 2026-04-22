<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreRequest extends FormRequest
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
            'name' => ['required','string', 'min:1'],
            'code' => ['required','string', 'digits:6',
               Rule::unique('stores', 'code')->ignore($this->route('store')->id),],
            'postal_code' => ['required', 'digits:7'],
            'prefecture' => ['required','string'],
            'city' => ['required','string'],
            'address_line' => ['required','string'],
            'is_active' => ['required','boolean'],
        ];
        return $rules;

    }

    protected function prepareForValidation(): void
    {
        $postal = $this->input('postal_code');

        if(is_string($postal)){
            $postal = mb_convert_kana($postal, 'n');
            $postal = preg_replace('/\D+/','',$postal);

            $this->merge([
                'postal_code'=>$postal,
            ]);
        }

        $code = $this->input('code');
        if(is_string($code)){
            $this->merge([
                'code'=>mb_convert_kana($code, 'n')
            ]);
        }
    }

    public function messages(): array
    {
        return[
            'name.required' => '店舗名は必須です',
            'code.required' => '店コードは必須です',
            'code.digits' => '店コードは６桁です',
            'code.unique' => '他店と同じコードは使用できません',
            'postal_code.required' => '郵便番号は必須です',
            'postal_code.digits' => '郵便番号はハイフンなしの７桁で入力してください',
            'prefecture.required' => '都道府県を入力してください',
            'city.required' => '市町村を入力してください',
            'address_line.required' => '番地以下を入力してください',
        ];
    }
}
