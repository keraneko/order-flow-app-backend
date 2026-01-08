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

            
        ];

        return  $rules ;
    }
} 
            
