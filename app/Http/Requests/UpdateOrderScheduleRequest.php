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
            'delivery_date' =>['required',"date_format:Y-m-d",'after_or_equal:today'],
            'delivery_from'=>['required', "date_format:H:i", ],
            'delivery_to'=>['nullable', "date_format:H:i"],
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

                if(blank($to)){
                     $validator->errors()->add('delivery_to', '配達希望時間の終了時間を選択してください');
                     return;
                }

                if(!is_string($from) || !is_string($to)){
                    return;
                }

                if($from >= $to){
                    $validator->errors()->add('delivery_to', '終了時間は開始時間より後の時間を選択してください');
                }
            });
        }

        public function messages(): array
        {
            return [
                'delivery_date.required' => '希望日を選択してください',
                'delivery_date.date_format' => '希望日は正しい形式で入力してください',
                'delivery_date.after_or_equal' => '希望日は今日以降の日付を選択してください',

                'delivery_from.required' => '商品受取の希望時間を選択してください',
                'delivery_from.date_format' => '商品受取の希望時間は正しい形式で入力してください',

                'delivery_to.date_format' => '配達希望時間の終了時間は正しい形式で入力してください',
            ];

        }
}
