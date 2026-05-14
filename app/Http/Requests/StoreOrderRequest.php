<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Order;
use Carbon\Carbon;



class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Order::class) ?? false;
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
            'fulfillment.deliveryDate' =>['required',"date_format:Y-m-d",],
            'fulfillment.deliveryFrom'=>['required', "date_format:H:i", ],
            'fulfillment.deliveryTo'=>['nullable','required_if:fulfillment.deliveryType,delivery', "date_format:H:i"],

            //customer
            'customer.name' => ['required', 'string', 'max:30'],
            'customer.phone' => ['required', 'string', 'min:10','max:11','regex:/^[0-9]+$/'],

            //order
            'customer.note' =>['nullable', 'string', 'max:255'],

            //order_item
            'items' => ['required', 'array', 'min:1'],
            'items.*.productId' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required','integer' ,'min:1'],
            'items.*.price' => ['required', 'integer','min:1'],
            'fulfillment.deliveryType'=> ['required', 'in:pickup,delivery'],
            'fulfillment.pickupStoreId' => ['required_if:fulfillment.deliveryType,pickup', 'integer', Rule::exists('stores','id')->where('is_active',true)],
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

            //希望日は2日以降でないとエラー
            $deliveryDate = $this->input('fulfillment.deliveryDate');

            if(is_string($deliveryDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/',$deliveryDate)){
                $date = Carbon::createFromFormat('!Y-m-d', $deliveryDate);
                $minDate = today()->addDays(2);
            
                if($date->lt($minDate)) {
                    $validator->errors()->add(
                       'fulfillment.deliveryDate', 
                        '希望日は2日後以降の日付を選択してください'
                    );
                }
            }


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

    public function messages(): array
    {
        return [
            // fulfillment
            'fulfillment.deliveryDate.required' => '希望日を選択してください',
            'fulfillment.deliveryDate.date_format' => '希望日は正しい形式で入力してください',

            'fulfillment.deliveryFrom.required' => '希望時間を選択してください',
            'fulfillment.deliveryFrom.date_format' => '希望時間は正しい形式で入力してください',

            'fulfillment.deliveryTo.required_if' => '配達希望時間の終了時間を選択してください',
            'fulfillment.deliveryTo.date_format' => '配達希望時間の終了時間は正しい形式で入力してください',

            'fulfillment.deliveryType.required' => '受け渡し方法を選択してください',
            'fulfillment.deliveryType.in' => '受け渡し方法の値が正しくありません',

            'fulfillment.pickupStoreId.required_if' => '受取店舗を選択してください',
            'fulfillment.pickupStoreId.integer' => '受取店舗の値が正しくありません',
            'fulfillment.pickupStoreId.exists' => '選択された受取店舗は現在利用できません',

            // customer
            'customer.name.required' => 'お名前を入力してください',
            'customer.name.max' => 'お名前は30文字以内で入力してください',
            

            'customer.phone.required' => '電話番号を入力してください',
            'customer.phone.max' => '電話番号は10桁以上11桁以内で入力してください',
            'customer.phone.min' => '電話番号は10桁以上11桁以内で入力してください',
            'customer.phone.regex' => '電話番号は数字のみで入力してください',

            'customer.note.max' => '備考は255文字以内で入力してください',

            'customer.deliveryAddress.required_if' => '配達先住所を入力してください',
            'customer.deliveryAddress.max' => '配達先住所は255文字以内で入力してください',

            'customer.deliveryPostalCode.required_if' => '郵便番号を入力してください',
            'customer.deliveryPostalCode.digits' => '郵便番号は7桁の数字で入力してください',

            // items
            'items.required' => '商品を1つ以上選択してください',
            'items.array' => '商品情報の形式が正しくありません',
            'items.min' => '商品を1つ以上選択してください',

            'items.*.productId.required' => '商品を選択してください',
            'items.*.productId.integer' => '商品の値が正しくありません',
            'items.*.productId.exists' => '選択された商品が存在しません',

            'items.*.quantity.required' => '数量を入力してください',
            'items.*.quantity.integer' => '数量は整数で入力してください',
            'items.*.quantity.min' => '数量は1以上で入力してください',

            'items.*.price.required' => '商品価格が取得できませんでした',
            'items.*.price.integer' => '商品価格の形式が正しくありません',
            'items.*.price.min' => '商品価格が正しくありません',
        ];
    }

} 
            
