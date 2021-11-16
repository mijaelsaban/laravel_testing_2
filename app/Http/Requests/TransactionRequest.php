<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
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
