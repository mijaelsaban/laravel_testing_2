<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'citizenship_country_id' => 'nullable|numeric',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_number' => 'nullable|numeric',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
