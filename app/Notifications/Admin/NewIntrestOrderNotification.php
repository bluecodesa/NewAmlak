<?php

namespace App\Notifications\Admin;

use App\Models\UnitInterest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewIntrestOrderNotification extends Notification
{
    use Queueable;


    private $intrestOrder;

    public function __construct(UnitInterest $intrestOrder)
    {
        $this->intrestOrder = $intrestOrder;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'msg' => __('A new Intrest Order has been added from a client name :') . ' ' . ($this->intrestOrder->name),
            'url' => route('Broker.Gallary.showInterests'),
            'type_noty' => 'NewIntrestOrder',
            'service_name' => 'NewIntrestOrder',
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
