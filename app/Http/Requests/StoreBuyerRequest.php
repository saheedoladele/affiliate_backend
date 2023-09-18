<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuyerRequest extends FormRequest
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
            'propertyId' => 'required|numeric',
            'consultantId' => 'numeric|required',
            'clientId' => 'required|numeric',
            'purchaseDate'=> 'required|date',
            'amountPaid' => 'required|numeric',
            'description' => 'string',
            'firstRef' => 'string',
            'secondRef' => 'string',
            'directRef' => 'string'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'amount_paid' => $this->amountPaid,
            'purchase_date' => $this->purchaseDate,
            'property_id' => $this->proertyId,
            'consultant_id' => $this->consultantId,
            'clinet_id'=> $this->clientId,
            'first_ref' => $this->firstRef,
            'second_ref' => $this->secondRef,
            'direct_ref' => $this->directRef,
         
        ]);
    }
}
