<?php

namespace Laraspace\Http\Requests;

use Laraspace\Http\Requests\Request;

class OrderpositionsRequest extends Request
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
            'title' => 'required|max:100',
            'description' => 'required',
            'price' => 'required|numeric',
            'cost' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
    }
}
