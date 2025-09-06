<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('slider-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $sliderId = $this->route('slider');

        return [
            // Main slider fields
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'boolean',

            // Translation fields
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.subtitle' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string|max:1000',
            'translations.*.button_text' => 'nullable|string|max:100',
            'translations.*.button_link' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'image' => 'şəkil',
            'sort_order' => 'sıralama',
            'translations.*.locale' => 'dil',
            'translations.*.title' => 'başlıq',
            'translations.*.subtitle' => 'alt başlıq',
            'translations.*.description' => 'təsvir',
            'translations.*.button_text' => 'düymə mətni',
            'translations.*.button_link' => 'düymə linki',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'image.image' => 'Fayl şəkil formatında olmalıdır.',
            'button_url.url' => 'Düzgün URL formatı daxil edin.',
            'translations.required' => 'Ən azı bir dil üçün tərcümə tələb olunur.',
            'translations.*.locale.required' => 'Dil sahəsi tələb olunur.',
            'translations.*.locale.in' => 'Dil yalnız az, en və ya tr ola bilər.',
            'translations.*.title.required' => 'Başlıq sahəsi tələb olunur.',
            'translations.*.slug.required' => 'Slug sahəsi tələb olunur.',
        ];
    }
}
