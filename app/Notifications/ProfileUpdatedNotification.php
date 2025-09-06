<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    /**
     * The updated fields.
     *
     * @var array
     */
    protected $updatedFields;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $updatedFields = [])
    {
        $this->updatedFields = $updatedFields;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $updatedFieldsList = '';
        
        foreach ($this->updatedFields as $field => $value) {
            $fieldName = $this->getFieldName($field);
            
            // Don't show password in email
            if ($field === 'password') {
                $value = '********';
            }
            
            $updatedFieldsList .= "- {$fieldName}: {$value}\n";
        }
        
        return (new MailMessage)
            ->subject('Profil məlumatlarınız yeniləndi')
            ->greeting('Hörmətli ' . $notifiable->name . ',')
            ->line('Hesabınızın profil məlumatları yeniləndi.')
            ->line('Yenilənən məlumatlar:')
            ->line($updatedFieldsList)
            ->line('Əgər bu yeniləməni siz etməmisinizsə, dərhal bizimlə əlaqə saxlayın.')
            ->action('Profilə keçid', url('/profile'))
            ->line('Xidmətlərimizdən istifadə etdiyiniz üçün təşəkkür edirik!');
    }
    
    /**
     * Get the human-readable field name.
     */
    protected function getFieldName(string $field): string
    {
        $fieldNames = [
            'birth_date' => 'Doğum tarixi',
            'birth_place' => 'Doğum yeri',
            'birth_country_id' => 'Doğulduğu ölkə',
            'birth_region_id' => 'Doğulduğu şəhər/rayon',
            'residence_country_id' => 'Yaşadığı ölkə',
            'residence_region_id' => 'Yaşadığı şəhər/rayon',
            'residence_address' => 'Yaşayış ünvanı',
            'education' => 'Təhsil',
            'job' => 'İş yeri',
            'position' => 'Vəzifə',
            'telegram' => 'Telegram',
            'twitter' => 'X (Twitter)',
            'wallet_address' => 'Blockchain cüzdan ünvanı',
            'bio' => 'Haqqında',
        ];
        
        return $fieldNames[$field] ?? $field;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
