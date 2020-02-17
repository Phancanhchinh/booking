<?php

namespace GD\Api\Http\Requests\Reply;

use Illuminate\Foundation\Http\FormRequest;

class CreateReplyRequest extends FormRequest
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
            'comment_id' => 'required|',
            'content' => 'required|min:10',
        ];
    }
    public function messages(){
        return [

        ];
    }
}
