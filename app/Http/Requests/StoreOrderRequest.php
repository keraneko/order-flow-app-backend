<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;


class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->role === 'store_user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            //fulfillmentDate
            'fulfillment.deliveryDate' =>['required', 'date',"date_format:Y-m-d", ],
            'fulfillment.deliveryFrom'=>['required', "date_format:H:i", ],
            'fulfillment.deliveryTo'=>['nullable','required_if:fulfillment.deliveryType,delivery', "date_format:H:i"],

            //customer
            'customer.name' => ['required', 'string', 'max:30'],
            'customer.phone' => ['required', 'string', 'max:12'],

            //order
            // 'fulfillment.orderStoreId' =>['required', 'integer', 'exists:stores,id'], バックエンドから取る
            'customer.note' =>['nullable', 'string', 'max:255'],

            //order_item
            'items' => ['required', 'array', 'min:1'],
            'items.*.productId' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required','integer' ,'min:1'],
            'items.*.price' => ['required', 'integer','min:1'],
            'fulfillment.deliveryType'=> ['required', 'in:pickup,delivery'],
            'fulfillment.pickupStoreId' => ['required_if:fulfillment.deliveryType,pickup', 'integer', 'exists:stores,id'],
            'customer.deliveryAddress' => ['required_if:fulfillment.deliveryType,delivery', 'string', 'max:255'],
            'customer.deliveryPostalCode' => ['required_if:fulfillment.deliveryType,delivery', 'string', 'digits:7'],

            
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

    public function withValidator(Validator $validator) : void
    {
        $validator->after(function(Validator $validator){
            $deliveryType = $this->input('fulfillment.deliveryType');

            if($deliveryType !== 'delivery'){ 
                return;
            }
                $from = $this->input('fulfillment.deliveryFrom');
                $to = $this->input('fulfillment.deliveryTo') ;

                if(!is_string($from) || !is_string($to)){
                    return;
                }

                if($from >= $to){
                    $validator->errors()->add('fulfillment.deliveryTo' , '受渡し時間は開始より後の時間を選んでください');
                } 
        });
        
    }

} 
            
