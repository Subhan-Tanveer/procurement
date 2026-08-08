<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name'    => ['required', 'string', 'max:255'],
            'customer_email'   => ['required', 'email', 'max:255'],
            'customer_phone'   => ['nullable', 'string', 'max:20'],
            'customer_company' => ['nullable', 'string', 'max:255'],
            'subject'          => ['nullable', 'string', 'max:255'],
            'message'          => ['nullable', 'string', 'max:5000'],
            'product_id'       => ['nullable', 'integer', 'exists:products,id'],
            'quantity'         => ['nullable', 'integer', 'min:1', 'max:10000'],
            'specifications'   => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required'  => 'Please enter your full name.',
            'customer_email.required' => 'Please enter your email address.',
            'customer_email.email'    => 'Please enter a valid email address.',
            'product_id.exists'       => 'The selected product is no longer available.',
            'quantity.min'            => 'Quantity must be at least 1.',
        ];
    }
}
