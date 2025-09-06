<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('partner-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Main partner fields
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean',

            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string|max:1000',
            'translations.*.website' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'logo' => 'loqo',
            'order' => 'sıra',
            'translations.*.locale' => 'dil',
            'translations.*.name' => 'ad',
            'translations.*.description' => 'təsvir',
            'translations.*.website' => 'veb sayt',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'logo.image' => 'Loqo bir şəkil olmalıdır.',
            'logo.mimes' => 'Loqo yalnız jpeg, png, jpg, gif və ya svg formatında olmalıdır.',
            'logo.max' => 'Loqo 2MB-dan böyük olmamalıdır.',
            'order.integer' => 'Sıra tam ədəd olmalıdır.',
            'order.min' => 'Sıra mənfi olmamalıdır.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.name.required' => 'Ad sahəsi tələb olunur.',
            'translations.*.website.url' => 'Veb sayt düzgün URL formatında olmalıdır.',
        ];
    }
}
