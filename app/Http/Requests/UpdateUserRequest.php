<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'sometimes|email',
            'phoneNumber' => 'sometimes|numeric',
            'address' => 'sometimes|string',
            'gender' =>'string',
            'dob' => 'date',
            'password' =>[
                'required',
                'confirmed',
                'sometimes'
                ]
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phoneNumber,
            'profile_picture' => $this->profilePicture,
            'refered_by' => $this->referedBy
        ]);
    }
}
