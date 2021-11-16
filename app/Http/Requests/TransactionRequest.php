<?php

namespace App\Http\Requests;

use App\Traits\HasJsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    use HasJsonResponse;

    public function rules(): array
    {
        return [
            'source' => [
                'required',
                Rule::in(['db', 'csv'])
            ]

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
