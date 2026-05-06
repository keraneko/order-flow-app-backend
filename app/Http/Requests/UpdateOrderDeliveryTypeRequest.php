<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderDeliveryTypeRequest extends FormRequest
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
        $deliveryType = $this->input('delivery_type');

        $rules = [
            'delivery_type' => ['required', 'in:pickup,delivery' ],
        ];
        
        if($deliveryType === 'pickup') {
            $rules['pickup_store_id'] = 'required|integer|exists:stores,id';
            

        }
        elseif($deliveryType === 'delivery') {
            $rules['delivery_postal_code'] ='required|string|digits:7';
            $rules['delivery_address'] = 'required|string|max:255';
        }  

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $postal = $this->input('delivery_postal_code');

        if(is_string($postal)) {
            $postal = mb_convert_kana($postal, 'n');
            $postal = preg_replace('/\D+/','',$postal);

            $this->merge([
                'delivery_postal_code'=>$postal,
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'delivery_type.required' => '受取方法を選択してください',
            'delivery_type.in' => '受取方法の値が正しくありません',

            'pickup_store_id.required' => '受取店舗を選択してください',
            'pickup_store_id.integer' => '受取店舗の値が正しくありません',
            'pickup_store_id.exists' => '選択された受取店舗が存在しません',

            'delivery_postal_code.required' => '郵便番号を入力してください',
            'delivery_postal_code.digits' => '郵便番号は7桁の数字で入力してください',

            'delivery_address.required' => '配達先住所を入力してください',
            'delivery_address.max' => '配達先住所は255文字以内で入力してください',
        ];
    }
}


