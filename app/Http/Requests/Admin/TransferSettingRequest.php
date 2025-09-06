<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TransferSettingRequest extends FormRequest
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
        $rules = [
            'currency' => ['required', 'string', 'max:10'],
            'min_amount' => ['required', 'numeric', 'min:0.01'],
            'max_amount' => ['required', 'numeric', 'gt:min_amount'],
            'fee_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'fee_fixed' => ['required', 'numeric', 'min:0'],
            'active' => ['boolean'],
        ];
        
        // Check for uniqueness only when creating a new record or updating a different currency
        if ($this->isMethod('post') || 
            ($this->isMethod('put') && $this->transferSetting->currency !== $this->currency)) {
            $rules['currency'][] = 'unique:transfer_settings,currency';
        }
        
        return $rules;
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
            'currency.unique' => 'Bu valyuta üçün artıq köçürmə parametrləri mövcuddur.',
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
        ];
    }
}
