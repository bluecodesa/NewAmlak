<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\ContactUs;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactUsNotification extends Notification
{
    use Queueable;


    private $ContactUs;

    public function __construct(ContactUs $ContactUs)
    {
        $this->ContactUs = $ContactUs;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'msg' => __('You have a new message in the Customer Messages section'),
            'url' => route('Admin.ContactUs'),
            'type_noty' => 'new message',
            'service_name' => 'new message',
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
