<?php

namespace GD\Api\Http\Requests\Reply;

use Illuminate\Foundation\Http\FormRequest;

class DeleteReplyRequest extends FormRequest
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
            'id_reply' => 'required|',
        ];
    }
    public function messages(){
        return [

        ];
    }
}
