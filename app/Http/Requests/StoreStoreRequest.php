<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'code' => ['required','string', 'digits:6','unique:stores,code'],
            'postal_code' => ['required', 'digits:7'],
            'prefecture' => ['required','string'],
            'city' => ['required','string'],
            'address_line' => ['required','string'],
            'is_active' => ['sometimes','boolean'],
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

}
