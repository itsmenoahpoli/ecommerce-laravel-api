<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
                    'name' => ['required', 'string', 'min:3', 'max:100', Rule::unique('product_categories')->whereNull('deleted_at')],
                ];
            case 'PATCH':
            case 'PUT':
                return [
                    'name' => ['required', 'string', 'min:3', 'max:100', Rule::unique('product_categories')->whereNull('deleted_at')],
                ];
            default:
                return [];

        }
    }
}
