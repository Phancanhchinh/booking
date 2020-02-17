<?php

namespace GD\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as Res;
class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) {
    	if (count($validator->errors()) > 0) {
    		$data = $validator->errors()->toArray();
	    	$dataValidator = [];
	    	foreach ($data as $key => $value) {
	    		$dataValidator[$key] = $value[0];
	    	}
		    throw new HttpResponseException(
			    response()->json([
			        'status' => 'error',
		            'status_code' => Res::HTTP_BAD_REQUEST,
		            'message' => 'Validation failed!',
			        'data' => $dataValidator,
			    ], 200)
		    );
    	}
	}
}
