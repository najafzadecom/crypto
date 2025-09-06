<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DepositMethodRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:10'],
            'type' => ['required', 'in:card,crypto,manual'],
            'min_amount' => ['required', 'numeric', 'min:0.01'],
            'max_amount' => ['required', 'numeric', 'gt:min_amount'],
            'fee_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'fee_fixed' => ['required', 'numeric', 'min:0'],
            'instructions' => ['nullable', 'string'],
            'qr_code' => ['nullable', 'image', 'max:5120'], // 5MB max
            'deposit_address' => ['nullable', 'string', 'max:255'],
            'active' => ['boolean'],
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
            'name.required' => 'Ad daxil edilməlidir.',
            'name.max' => 'Ad çox uzundur.',
            'currency.required' => 'Valyuta seçilməlidir.',
            'currency.max' => 'Valyuta kodu çox uzundur.',
            'type.required' => 'Ödəniş növü seçilməlidir.',
            'type.in' => 'Ödəniş növü yalnız kart, kripto və ya manual ola bilər.',
            'min_amount.required' => 'Minimum məbləğ daxil edilməlidir.',
            'min_amount.numeric' => 'Minimum məbləğ rəqəm olmalıdır.',
            'min_amount.min' => 'Minimum məbləğ ən azı 0.01 olmalıdır.',
            'max_amount.required' => 'Maksimum məbləğ daxil edilməlidir.',
            'max_amount.numeric' => 'Maksimum məbləğ rəqəm olmalıdır.',
            'max_amount.gt' => 'Maksimum məbləğ minimum məbləğdən böyük olmalıdır.',
            'fee_percentage.required' => 'Komissiya faizi daxil edilməlidir.',
            'fee_percentage.numeric' => 'Komissiya faizi rəqəm olmalıdır.',
            'fee_percentage.min' => 'Komissiya faizi mənfi ola bilməz.',
            'fee_percentage.max' => 'Komissiya faizi 100-dən çox ola bilməz.',
            'fee_fixed.required' => 'Sabit komissiya daxil edilməlidir.',
            'fee_fixed.numeric' => 'Sabit komissiya rəqəm olmalıdır.',
            'fee_fixed.min' => 'Sabit komissiya mənfi ola bilməz.',
            'deposit_address.max' => 'Depozit ünvanı çox uzundur.',
            'qr_code.image' => 'QR kod şəkil formatında olmalıdır.',
            'qr_code.max' => 'QR kod şəkli 5MB-dan böyük olmamalıdır.',
        ];
    }
}
