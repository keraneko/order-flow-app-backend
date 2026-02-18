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
                //date
                'date.deliveryDate' =>['required', 'date',"date_format:Y-m-d", ],
                'date.deliveryFrom'=>['required', "date_format:H:i", ],
                'date.deliveryTo'=>['nullable','required_if:customer.deliveryType,delivery', "date_format:H:i"],

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

    public function withValidator(Validator $validator) : void
    {
        $validator->after(function(Validator $validator){
            $deliveryType = $this->input('customer.deliveryType');

            if($deliveryType !== 'delivery'){ 
                return;
            }
                $from = $this->input('date.deliveryFrom');
                $to = $this->input('date.deliveryTo') ;

                if(!is_string($from) || !is_string($to)){
                    return;
                }

                if($from >= $to){
                    $validator->errors()->add('date.deliveryTo' , '受渡し時間は開始より後の時間を選んでください');
                } 
        });
        
    }

} 
            
