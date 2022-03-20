<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'nullable|numeric',
            'customer_name' => 'string|min:2|max:32',
            'customer_email' => 'email|min:2|max:64',
            'total_amount' => 'numeric|required',
            'delivery_notes' => 'string',
            'shipping_address.address' => 'string',
            'shipping_address.barangay' => 'string',
            'shipping_address.city' => 'string',
            'shipping_address.zip_code' => 'string',
            'shipping_address.contact_number' => 'string',
            'shipping_address.region' => 'string',
            'order_products' => 'array'
        ];
    }
}
