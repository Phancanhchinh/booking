<?php

namespace GD\Api\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCommentRequest extends FormRequest
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
            'id_comment' => 'required|',
        ];
    }
    public function messages(){
        return [

        ];
    }
}
