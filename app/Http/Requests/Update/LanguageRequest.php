<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('language-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $languageId = $this->route('language');

        return [
            'code' => 'required|string|max:10|unique:languages,code,' . $languageId,
            'locale' => 'required|string|max:10|unique:languages,locale,' . $languageId,
            'name' => 'required|string|max:255',
            'flag' => 'nullable|string|max:255',
            'status' => 'boolean',
        ];
    }
}
