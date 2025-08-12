<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        $newsId = $this->route('news');
        
        return [
            // Main news fields
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'status' => 'boolean',
            
            // Translation fields
            'translations' => 'required|array',
            'translations.*.locale' => 'required|string|in:az,en,tr',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.slug' => 'required|string|max:255',
            'translations.*.content' => 'required|string',
            'translations.*.excerpt' => 'nullable|string|max:500',
        ];
    }
}
