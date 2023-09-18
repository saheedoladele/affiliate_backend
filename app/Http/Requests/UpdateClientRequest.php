<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'clientName' => 'required|string|max:120',
            'email' => 'required|email|unique:clients,email',
            'phoneNumber' => 'required|numeric',
            'gender'=> 'required|string',
            'address' => 'string',
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'client_name' => $this->clientName,
            'phone_number' => $this->phoneNumber
        ]);
    }
}
