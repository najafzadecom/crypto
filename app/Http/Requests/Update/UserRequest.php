<?php

namespace App\Http\Requests\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('user-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'username' => 'required|unique:users,username,' . $this->route('user'),
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'array',
            'telegram' => 'nullable',
            'status' => 'boolean',
            'permissions.*' => 'exists:permissions,id'
        ];
    }
}
