<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = auth()->user();

        return [
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_country_id' => ['nullable', 'exists:countries,id'],
            'birth_region_id' => ['nullable', 'exists:regions,id'],
            
            'residence_country_id' => ['nullable', 'exists:countries,id'],
            'residence_region_id' => ['nullable', 'exists:regions,id'],
            'residence_address' => ['nullable', 'string', 'max:255'],
            
            'education' => ['nullable', 'string', 'max:255'],
            'job' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            
            'telegram' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            
            'wallet_address' => [
                'nullable', 
                'string', 
                'max:42',
                function ($attribute, $value, $fail) {
                    if ($value && !User::isValidWalletAddress($value)) {
                        $fail('Cüzdan ünvanı düzgün BEP20 formatında deyil. 0x ilə başlayan 42 simvol olmalıdır.');
                    }
                },
            ],
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'birth_country_id.exists' => 'Seçilmiş doğum ölkəsi mövcud deyil.',
            'birth_region_id.exists' => 'Seçilmiş doğum şəhəri/rayonu mövcud deyil.',
            'residence_country_id.exists' => 'Seçilmiş yaşayış ölkəsi mövcud deyil.',
            'residence_region_id.exists' => 'Seçilmiş yaşayış şəhəri/rayonu mövcud deyil.',
        ];
    }
    
    /**
     * Check if the profile is blocked from updates.
     */
    public function isProfileBlocked(): bool
    {
        $user = auth()->user();
        return $user->isProfileBlocked();
    }
    
    /**
     * Get the error message for a blocked profile.
     */
    public function getBlockedMessage(): string
    {
        $user = auth()->user();
        $blockedUntil = $user->profile_blocked_until->format('d.m.Y H:i');
        
        return "Profiliniz {$blockedUntil} tarixinə qədər bloklanıb. Profil məlumatlarınızı yeniləmək üçün gözləyin.";
    }
}
