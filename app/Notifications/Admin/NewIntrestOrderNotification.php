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
        $office=null;
        $broker=null;
        $office=$this->intrestOrder->unit->OfficeData;
        $broker=$this->intrestOrder->unit->BrokerData;
        if($broker){
            $url= 'Broker.Gallary.showInterests';
        }elseif($office){
            $url='Office.Gallary.showInterests';
        }
        return [
            'msg' => __('Unit') . ' ' . ($unit_name),
            'url' => route($url),
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
