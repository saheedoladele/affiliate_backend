<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'firstName' => 'required|string|max:55',
            'lastName' => 'required|string|max:55',
            'username' => 'required|string|unique:admins,username',
            'role' => 'string|nullable',
            'password' =>[
                'required',
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
