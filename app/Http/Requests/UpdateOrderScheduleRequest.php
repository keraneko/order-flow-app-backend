<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateOrderScheduleRequest extends FormRequest
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
            'delivery_date' =>['required', 'date',"date_format:Y-m-d", ],
            'delivery_from'=>['required', "date_format:H:i", ],
            'delivery_to'=>['nullable','required_if:customer.deliveryType,delivery', "date_format:H:i"],
        ];
        return $rules;
    }

        public function withValidator(Validator $validator) : void
        {
            $validator->after(function(Validator $validator){
                $order = $this->route('order');
                $deliveryType = $order->delivery_type;

                if($deliveryType !== 'delivery'){
                    return;
                }
                $from = $this->input('delivery_from');
                $to = $this->input('delivery_to');

                if(!is_string($from) || !is_string($to)){
                    return;
                }

                if($from >= $to){
                    $validator->errors()->add('delivery_to', '受渡し時間は開始より後の時間を選んでください');
                }
            });
        }
}
