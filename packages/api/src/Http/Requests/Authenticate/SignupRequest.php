<?php

namespace GD\Api\Http\Requests\Authenticate;

use Illuminate\Foundation\Http\FormRequest;
use GD\Api\Http\Requests\BaseFormRequest;

class SignupRequest extends BaseFormRequest
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
            'first_name' => 'required|max:10',
            'last_name'  => 'required|max:10',
            'username'   => 'required|max:20',
            'password'   => 'required|min:6|max:32',
            'email'      => 'required|email',
            'dob'        => 'required',
            'phone'      => 'required|min:10|max:12',
            'gender'     => 'required|max:1',
            'address'    => 'required',
            'type'       => 'required|max:1'
        ];
    }
}
