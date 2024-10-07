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
        $user_id = $this->user->id;
        $user = User::where('id', $user_id)->first();

        if ($user->is_property_finder) {
            $type_noty = 'New Property Finder';
            $service_name = 'NewPropertyFinder';
        } elseif ($user->is_owner) {
            $type_noty = 'New Owner Registered';
            $service_name = 'NewOwner';
        } else {
            $type_noty = 'New User';
            $service_name = 'NewUser';
        }

        return [
            'msg' => __('') . ' ' . ($user->name),
            'url' => route('Admin.Subscribers.show', $user->id),
            'type_noty' => $type_noty,
            'service_name' => $service_name,
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
