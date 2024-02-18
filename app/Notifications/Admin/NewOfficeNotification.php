<?php

namespace App\Notifications\Admin;

use App\Models\Office;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOfficeNotification extends Notification
{
    use Queueable;


    private $office;

    public function __construct(Office $office)
    {
        $this->office = $office;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'msg' => __('A new office has been added to the platform with the name:') . ' ' . ($this->office->company_name),
            'url' => route('Admin.Subscribers.index'),
            'type_noty' => 'NewOffice',
            'service_name' => 'NewOffice',
            'created_at' => now(),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}