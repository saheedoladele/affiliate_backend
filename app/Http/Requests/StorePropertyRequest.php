<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
            'propertyName' => 'required|string',
            'description' => 'required|string',
            'actualPrice' => 'required|numeric',
            'location' => 'string',
            'promoPrice' => 'numeric',
            'surveyPrice' => 'required|numeric',
            'promoDetails' => 'string',
            'cofo' => 'string',
            'deedofAssignment' => 'string',
            'developmentalLevy' => 'numeric',
            'images' => 'required|image|mimes:png,jpg,gif,jpeg,svg|max:2048'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'property_name' => $this->propertyName,
            'actual_price' => $this->actualPrice,
            'promo_price' => $this->promoPrice,
            'survey_price' => $this->surveyPrice,
            'deed_of_assignment' => $this->deedofAssignment,
            'c_of_o' => $this->cofo,
            'promo_details' => $this->promoDetails,
            // 'images' => $this->images,
            'developmental_levy' => $this->developmentalLevy
        ]);
}
}
