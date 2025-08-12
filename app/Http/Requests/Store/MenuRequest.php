<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        return [
            // Main menu fields
            'location' => 'required|string|max:255|unique:menus,location',
            'status' => 'boolean',
            
            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.slug' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'location' => 'yerləşim',
            'translations.*.locale' => 'dil',
            'translations.*.name' => 'ad',
            'translations.*.slug' => 'slug',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'location.required' => 'Yerləşim sahəsi tələb olunur.',
            'location.unique' => 'Bu yerləşim artıq mövcuddur.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.name.required' => 'Ad sahəsi tələb olunur.',
            'translations.*.slug.required' => 'Slug sahəsi tələb olunur.',
        ];
    }
}