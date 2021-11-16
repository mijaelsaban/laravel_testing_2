<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'citizenship_country_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
