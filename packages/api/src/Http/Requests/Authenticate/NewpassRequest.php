<?php

namespace GD\Api\Http\Requests\Authenticate;

use Illuminate\Foundation\Http\FormRequest;
use GD\Api\Http\Requests\BaseFormRequest;

class NewpassRequest extends BaseFormRequest
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
            'token'    => 'required',
            'password' => 'required|min:6|max:32',
        ];
    }
}
