<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderCustomerRequest extends FormRequest
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
            
            'name' => ['required', 'string', 'max:30'],
            'phone' => ['required', 'string', 'max:11', 'min:10' ,'regex:/^[0-9]+$/'],
            'address' =>['nullable', 'string', 'max:255'], 
        ];
        return $rules;
    }
}
