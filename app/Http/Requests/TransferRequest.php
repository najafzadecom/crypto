<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'recipient' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'recipient.required' => 'Alıcı məlumatı daxil edilməlidir.',
            'recipient.string' => 'Alıcı məlumatı mətn formatında olmalıdır.',
            'recipient.max' => 'Alıcı məlumatı çox uzundur.',
            'amount.required' => 'Məbləğ daxil edilməlidir.',
            'amount.numeric' => 'Məbləğ rəqəm olmalıdır.',
            'amount.min' => 'Məbləğ ən azı 1 olmalıdır.',
            'description.max' => 'Təsvir çox uzundur.',
        ];
    }
}
