<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('country-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Main country fields
            'code' => 'required|string|size:2|unique:countries,code',
            'phone_code' => 'nullable|string|max:10',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'boolean',

            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.name' => 'required|string|max:255'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'code' => 'kod',
            'phone_code' => 'telefon kodu',
            'flag' => 'bayraq',
            'status' => 'status',
            'translations.*.locale' => 'dil',
            'translations.*.name' => 'ad'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kod sahəsi tələb olunur.',
            'code.size' => 'Kod 2 simvol olmalıdır.',
            'code.unique' => 'Bu kod artıq istifadə olunur.',
            'flag.image' => 'Bayraq bir şəkil olmalıdır.',
            'flag.mimes' => 'Bayraq yalnız jpeg, png, jpg, gif və ya svg formatında olmalıdır.',
            'flag.max' => 'Bayraq 2MB-dan böyük olmamalıdır.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.name.required' => 'Ad sahəsi tələb olunur.',
        ];
    }
}
