<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResponseTicketNotification extends Notification
{
    use Queueable;


    private $response;

    public function __construct(TicketResponse $response)
    {
        $this->response = $response;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $user_id=$this->response->user_id;
        $ticket_id=$this->response->ticket_id;
        $formattedId = "100{$this->response->ticket_id}";
        $ticket=Ticket::where('id',$ticket_id)->first();
        $type=$ticket->ticketType->name;
        $ticket = $this->response->TicketData;
        $user =$ticket->UserData;
        if($user->is_broker){
            $url ='Broker.Tickets.show';
        }elseif($user->is_office){
            $url ='Office.Tickets.show';

        }elseif($user->is_service_provider)
        {
            $url ='ServiceProvider.Tickets.show';
        }


        return [
            'msg' => __('') . ' ' . ($formattedId).' : '.($type),
            'url' => route($url, $ticket_id),
            'type_noty' => 'You have an update on a support ticket',
            'service_name' => 'ResponseTicket',
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
