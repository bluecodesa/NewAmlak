<?php

namespace App\Notifications\Admin;

use App\Models\Office;
use App\Models\Subscription;
use App\Models\User;
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
        $user_id=$this->office->user_id;
        $user=User::where('id',$user_id)->first();
        $office=Office::where('user_id',$user_id)->first();
        $subscriber=Subscription::where('office_id',$office->id)->first();
        $subscriptionType = $subscriber->SubscriptionTypeData;
        $subscriptionTypeName = $subscriptionType ? $subscriptionType->name : '';

        return [
            'msg' => __('') . ' ' . ($user->name).' '. __('Subscription Type'). ' ' .($subscriptionTypeName),
            'url' => route('Admin.Subscribers.show', $subscriber->id),
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
