<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketNotification extends Notification
{
    use Queueable;


    private $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $formattedId = "100{$this->ticket->id}";
        $type=$this->ticket->ticketType->name;

        return [
            'msg' => __('') . ' ' . ($formattedId).' : '.($type),
            'url' => route('Admin.SupportTickets.show',$this->ticket->id),
            'type_noty' => 'You have a new support ticket',
            'service_name' => 'NewTicket',
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
