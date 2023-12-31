<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName' => 'sometimes|string|max:55',
            'lastName' => 'sometimes|string|max:55',
            'username' => 'sometimes|string|unique:admins,email',
            'role' => 'sometimes|string|nullable',
            'password' =>[
                'sometimes',
                'confirmed'
                ]
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName
        ]);
    }
}
