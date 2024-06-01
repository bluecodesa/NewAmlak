<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPropertyFinderNotification extends Notification
{
    use Queueable;


    private $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $user_id=$this->user->id;
        $user=User::where('id',$user_id)->first();
        return [
            'msg' => __('') . ' ' . ($user->name) ,
            'url' => route('Admin.Subscribers.show', $user->id),
            'type_noty' => 'NewPropertyFinder',
            'service_name' => 'NewPropertyFinder',
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
