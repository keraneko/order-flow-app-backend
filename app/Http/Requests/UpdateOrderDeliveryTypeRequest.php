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
        
        if($deliveryType === 'pickup'){
            $rules['pickup_store_id'] = 'required|integer|exists:stores,id';
            

        }
        elseif($deliveryType === 'delivery'){
            $rules['delivery_postal_code'] ='required|string|digits:7';
            $rules['delivery_address'] = 'required|string|max:255';
        }  

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $postal = $this->input('delivery_postal_code');

        if(is_string($postal)){
            $postal = mb_convert_kana($postal, 'n');
            $postal = preg_replace('/\D+/','',$postal);

            $this->merge([
                'delivery_postal_code'=>$postal,
            ]);
        }
    }
}


