<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $packageId = $this->route('package');

        return [
            // Main package fields
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'duration_days' => 'nullable|integer|min:1',
            'is_popular' => 'boolean',
            'status' => 'boolean',

            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string|max:1000',
            'translations.*.features' => 'nullable|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'price' => 'qiymət',
            'currency' => 'valyuta',
            'duration_days' => 'müddət (gün)',
            'is_popular' => 'populyar',
            'translations.*.locale' => 'dil',
            'translations.*.name' => 'ad',
            'translations.*.description' => 'təsvir',
            'translations.*.features' => 'xüsusiyyətlər',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'price.required' => 'Qiymət sahəsi tələb olunur.',
            'price.numeric' => 'Qiymət rəqəm olmalıdır.',
            'currency.required' => 'Valyuta sahəsi tələb olunur.',
            'currency.size' => 'Valyuta 3 simvol olmalıdır.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.name.required' => 'Ad sahəsi tələb olunur.'
        ];
    }
}
