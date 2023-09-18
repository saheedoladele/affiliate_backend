<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankRequest extends FormRequest
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
            'bankName' => 'required|string',
            'accountNumber' => 'numeric|required',
            'accountName' => 'required|string',
            'userId'=> 'required|numeric'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'bank_name' => $this->bankName,
            'account_number' => $this->accountNumber,
            'account_name' => $this->accountName,
            'user_id' => $this->userId
            
        ]);
    }
}
