<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait HasJsonResponse
{
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

}
