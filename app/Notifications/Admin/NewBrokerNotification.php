<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBrokerNotification extends Notification
{
    use Queueable;


    private $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $user_id=$this->broker->user_id;
        $user=User::where('id',$user_id)->first();

    $subscriptionType = $this->broker->subscriptionType;
    $subscriptionTypeName = $subscriptionType ? $subscriptionType->name : '';
        return [
            'msg' => __('A new Broker Risgter') . ' ' . ($user->name).' '. __('Subscription Type'). ' ' .($subscriptionTypeName),
            'url' => route('Admin.Subscribers.index'),
            'type_noty' => 'NewBroker',
            'service_name' => 'NewBroker',
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