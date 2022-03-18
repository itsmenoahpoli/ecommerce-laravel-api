<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Rule;

class ProductRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
                return [];
            case 'DELETE':
                return [
                    'type' => 'string'
                ];
            case 'POST':
                return [
                    'name' => ['required', 'string', 'min:5', 'max:100', Rule::unique('products')->whereNull('deleted_at')],
                    'description' => 'required|string|min:5|max:500',
                    'quantity' => 'required|integer',
                    'price' => 'required|numeric',
                    'type' => 'string|min:2|max:64',
                    'image' => 'required|mimes:jpg,png'
                ];
            case 'PATCH':
            case 'PUT':
                return [
                    'name' => 'required|string|min:5|max:100',
                    'description' => 'required|string|min:5|max:500',
                    'quantity' => 'required|integer',
                    'price' => 'required|numeric',
                    'type' => 'string|min:2|max:64'
                ];
            default:
                return [];

        }
    }
}
