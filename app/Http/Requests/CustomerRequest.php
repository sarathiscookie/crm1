<?php

namespace Laraspace\Http\Requests;

use Laraspace\Http\Requests\Request;

class CustomerRequest extends Request
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
            'firstname'  => 'required|max:100',
            'lastname'   => 'required|max:100',
            'mail'       => 'required|email|max:255|unique:customers,mail,'.$this->id,
            'street'     => 'required',
            'postal'     => 'required|max:30',
            'city'       => 'required|max:50',
            'country'    => 'required|max:100',
        ];
    }
}
