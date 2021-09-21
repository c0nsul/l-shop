<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $updateRule = isset($this->product->id) ? "," . $this->product->id : null;
        $rules = [
            'code' => 'required|min:3|max:255|unique:products,code' . $updateRule,
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:5',
            'price' => 'required|numeric|min:1',
            'count' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
            'hit' => 'string',
            'new' => 'string',
            'recommend' => 'string',
        ];

        return $rules;
    }
}
