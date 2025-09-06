<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BalanceAdjustmentRequest extends FormRequest
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
            'currency' => ['required', 'string', 'max:10'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'adjustment_type' => ['required', 'in:increase,decrease'],
            'notes' => ['nullable', 'string', 'max:255'],
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
            'currency.required' => 'Valyuta seçilməlidir.',
            'currency.max' => 'Valyuta kodu çox uzundur.',
            'amount.required' => 'Məbləğ daxil edilməlidir.',
            'amount.numeric' => 'Məbləğ rəqəm olmalıdır.',
            'amount.min' => 'Məbləğ ən azı 0.01 olmalıdır.',
            'adjustment_type.required' => 'Əməliyyat növü seçilməlidir.',
            'adjustment_type.in' => 'Əməliyyat növü yalnız artırma və ya azaltma ola bilər.',
            'notes.max' => 'Qeydlər çox uzundur.',
        ];
    }
}
