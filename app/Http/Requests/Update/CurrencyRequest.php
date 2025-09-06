<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('currency-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:3|unique:currencies,code,' . $this->route('currency'),
            'symbol' => 'required|string|max:10',
            'rate' => 'required|numeric|min:0',
            'is_default' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'ad',
            'code' => 'kod',
            'symbol' => 'simvol',
            'rate' => 'məzənnə',
            'is_default' => 'əsas valyuta',
            'status' => 'status',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ad sahəsi tələb olunur.',
            'code.required' => 'Kod sahəsi tələb olunur.',
            'code.size' => 'Kod 3 simvol olmalıdır.',
            'code.unique' => 'Bu kod artıq istifadə olunur.',
            'symbol.required' => 'Simvol sahəsi tələb olunur.',
            'rate.required' => 'Məzənnə sahəsi tələb olunur.',
            'rate.numeric' => 'Məzənnə rəqəm olmalıdır.',
            'rate.min' => 'Məzənnə mənfi olmamalıdır.',
        ];
    }
}
