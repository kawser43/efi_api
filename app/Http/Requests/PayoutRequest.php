<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PayoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'capital' => ['nullable', 'numeric'],
            'tax' => ['nullable', 'numeric'],
            'partial' => ['nullable', 'numeric'],
            'profit' => ['nullable', 'numeric'],
            'available_amount_after_tax' => ['nullable', 'numeric'],
            'payout_actual' => ['nullable', 'numeric'],
            'payout_actual_transfer' => ['nullable', 'numeric'],
            'exchange_rate' => ['nullable', 'numeric'],

            'transfer_currency' => ['nullable', 'string'],
            'payout_status' => ['nullable', 'string', 'in:Open,Paid,Hold'],
            'platform' => ['nullable', 'string', 'in:wallex'], // add more platforms if needed
            'investment_status' => ['nullable', 'string', 'in:Pending,Done'],

            'purpose' => ['nullable', 'string', 'max:255'],
            'payout_date' => ['nullable', 'date'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
            'data' => null,
            'errors' => $validator->errors(),
        ], 422));
    }
}
