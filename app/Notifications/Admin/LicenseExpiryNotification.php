<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\FalLicenseUser;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseExpiryNotification extends Notification
{
    use Queueable;


    private $message,$license;

    public function __construct(FalLicenseUser $license, $message)
    {
        $this->message = $message;
        $this->license = $license;

    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {

        $license = $this->license;
        
        return [
            'msg' => __('') . ' ' . $this->message,
            'url' => route('Broker.Setting.index'),
            'type_noty' => 'License Expiry Notification',
            'service_name' => 'LicenseService',
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
