<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'payment_type' => 'required|in:cash,dp,credit',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:1000',
            'dp_amount' => 'required_if:payment_type,dp,credit|nullable|numeric|min:0',
            'credit_months' => 'required_if:payment_type,credit|nullable|integer|in:6,12,18,24,36',
            'customer_ktp' => 'required_if:payment_type,credit|nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
