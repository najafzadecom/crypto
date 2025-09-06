<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'deposit_method_id' => ['required', 'exists:deposit_methods,id,active,1'],
            'amount' => ['required', 'numeric', 'min:1'],
            'crypto_address' => ['nullable', 'string', 'max:255'],
            'crypto_transaction_id' => ['nullable', 'string', 'max:255'],
            'screenshot' => ['nullable', 'image', 'max:5120'], // 5MB max
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'deposit_method_id.required' => 'Ödəniş üsulu seçilməlidir.',
            'deposit_method_id.exists' => 'Seçilmiş ödəniş üsulu mövcud deyil və ya aktiv deyil.',
            'amount.required' => 'Məbləğ daxil edilməlidir.',
            'amount.numeric' => 'Məbləğ rəqəm olmalıdır.',
            'amount.min' => 'Məbləğ ən azı 1 olmalıdır.',
            'crypto_address.max' => 'Kripto ünvanı çox uzundur.',
            'crypto_transaction_id.max' => 'Kripto əməliyyat ID çox uzundur.',
            'screenshot.image' => 'Fayl şəkil formatında olmalıdır.',
            'screenshot.max' => 'Şəkil 5MB-dan böyük olmamalıdır.',
        ];
    }
}
