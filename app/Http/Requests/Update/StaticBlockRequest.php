<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StaticBlockRequest extends FormRequest
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
        $staticBlockId = $this->route('static_block');
        
        return [
            // Main static block fields
            'status' => 'boolean',
            
            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.slug' => 'required|string|max:255',
            'translations.*.content' => 'required|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'translations.*.locale' => 'dil',
            'translations.*.title' => 'başlıq',
            'translations.*.slug' => 'slug',
            'translations.*.content' => 'məzmun',
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
            'translations.*.title.required' => 'Başlıq sahəsi tələb olunur.',
            'translations.*.slug.required' => 'Slug sahəsi tələb olunur.',
            'translations.*.content.required' => 'Məzmun sahəsi tələb olunur.',
        ];
    }
}