<?php

namespace App\Notifications\Admin;


use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceiptStatusUpdatedNotification extends Notification
{

    use Queueable;

    protected $receipt;
    protected $newStatus;

    /**
     * Create a new notification instance.
     *
     * @param $receipt
     * @param $newStatus
     */
    public function __construct($receipt, $newStatus)
    {
        $this->receipt = $receipt;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {


        return [
            'msg' => __( ($this->receipt->receipt_id)),
            'url' => route('Office.ShowSubscription'),
            'type_noty' => 'Your subscription is active now!',
            'service_name' => '',
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
