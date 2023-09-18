<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'required|numeric|unique:users,phone_number',
            'address' => 'string|nullable',
            'referedBy' => 'string',
            'referalCode' => 'string',
            'gender' =>'string|nullable',
            'dob' => 'date|nullable',
            'profilePicture' => 'image|mimes:png,jpg,gif,jpeg,svg|max:2048',
            'password' =>[
                'required',
                'confirmed'
                ]
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phoneNumber,
            'profile_picture' => $this->profilePicture,
            'refered_by' => $this->referedBy,
            'referal_code' => $this->referalCode
        ]);
    }
}
