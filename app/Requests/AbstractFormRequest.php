<?php

namespace App\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class AbstractFormRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return HttpResponseException
     */
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new
        HttpResponseException(response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
