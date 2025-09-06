<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('testimonial-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Main testimonial fields
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'boolean',

            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.position' => 'nullable|string|max:255',
            'translations.*.comment' => 'required|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'image' => 'şəkil',
            'company' => 'şirkət',
            'rating' => 'reytinq',
            'translations.*.locale' => 'dil',
            'translations.*.name' => 'ad',
            'translations.*.position' => 'vəzifə',
            'translations.*.comment' => 'şərh',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Reytinq sahəsi tələb olunur.',
            'rating.min' => 'Reytinq ən azı 1 olmalıdır.',
            'rating.max' => 'Reytinq ən çox 5 ola bilər.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.name.required' => 'Ad sahəsi tələb olunur.',
            'translations.*.comment.required' => 'Şərh sahəsi tələb olunur.',
        ];
    }
}
