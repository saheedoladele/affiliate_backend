<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBankRequest extends FormRequest
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
            'bankName' => 'sometimes|string',
            'accountNumber' => 'numeric|sometimes',
            'accountName' => 'sometimes|string',
            'userId'=> 'sometimes|numeric'
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
