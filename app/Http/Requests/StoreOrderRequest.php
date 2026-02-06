<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            //customer
            'customer.name' => ['required', 'string', 'max:30'],
            'customer.phone' => ['required', 'string', 'max:12'],

            //order
            'customer.orderStoreId' =>['required', 'integer', 'exists:stores,id'],
            'customer.note' =>['nullable', 'string', 'max:255'],

            //order_item
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required','integer' ,'min:1'],
            'items.*.price' => ['required', 'integer','min:1'],
            'customer.deliveryType'=> ['required', 'in:pickup,delivery'],
            'customer.pickupStoreId' => ['required_if:customer.deliveryType,pickup', 'integer', 'exists:stores,id'],
            'customer.deliveryAddress' => ['required_if:customer.deliveryType,delivery', 'string', 'max:255'],
            'customer.deliveryPostalCode' => ['required_if:customer.deliveryType,delivery', 'string', 'digits:7'],

            
        ];

        return  $rules ;
    }

        protected function prepareForValidation(): void
    {
        $postal = $this->input('customer.deliveryPostalCode');

        if(is_string($postal)){
            $postal = mb_convert_kana($postal, 'n');
            $postal = preg_replace('/\D+/','',$postal);

            $this->merge([
                'customer.deliveryPostalCode'=>$postal,
            ]);
        }
    }

} 
            
