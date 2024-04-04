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
        $unit_name=$this->intrestOrder->unit->number_unit;

        return [
            'msg' => __('') . ' ' . ($unit_name),
            'url' => route('Broker.Gallary.showInterests'),
            'type_noty' => 'You have a new Intrest Order',
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
