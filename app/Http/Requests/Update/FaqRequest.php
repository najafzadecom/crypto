<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
        $faqId = $this->route('faq');
        
        return [
            // Main faq fields
            'status' => 'boolean',
            
            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.question' => 'required|string|max:500',
            'translations.*.slug' => 'required|string|max:255',
            'translations.*.answer' => 'required|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'translations.*.locale' => 'dil',
            'translations.*.question' => 'sual',
            'translations.*.slug' => 'slug',
            'translations.*.answer' => 'cavab',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.question.required' => 'Sual sahəsi tələb olunur.',
            'translations.*.slug.required' => 'Slug sahəsi tələb olunur.',
            'translations.*.answer.required' => 'Cavab sahəsi tələb olunur.',
        ];
    }
}