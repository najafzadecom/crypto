<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
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
        $settingId = $this->route('setting');

        return [
            'key'           => ['required', 'string', 'max:255', Rule::unique('settings')->ignore($settingId)],
            'name'          => 'required|string|max:255',
            'value'         => 'nullable',
            'type'          => 'required|string|in:text,number,boolean,json,file,email,url,textarea,select,radio,checkbox',
            'group'         => 'required|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'key.required' => 'Açar sahəsi tələb olunur.',
            'key.unique' => 'Bu açar artıq mövcuddur.',
            'name.required' => 'Ad sahəsi tələb olunur.',
            'type.required' => 'Tip sahəsi tələb olunur.',
            'type.in' => 'Seçilmiş tip etibarlı deyil.',
            'group.required' => 'Qrup sahəsi tələb olunur.',
        ];
    }
}
