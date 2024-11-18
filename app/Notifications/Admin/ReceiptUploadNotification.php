<?php

namespace App\Notifications\Admin;


use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceiptUploadNotification extends Notification
{

    use Queueable;

    protected $newReceipt;

    /**
     * Create a new notification instance.
     *
     * @param $receipt
     * @param $newStatus
     */
    public function __construct($newReceipt)
    {
        $this->newReceipt = $newReceipt;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable): array
    {
         // Determine the client name based on available relationships
    $client_name = '';

    if ($this->newReceipt->office_id && $this->newReceipt->OfficeData) {
        $client_name = $this->newReceipt->OfficeData->UserData->name;
    } elseif ($this->newReceipt->broker_id && $this->newReceipt->BrokerData) {
        $client_name = $this->newReceipt->BrokerData->UserData->name;
    } elseif ($this->newReceipt->owner_id && $this->newReceipt->OwnerData) {
        $client_name = $this->newReceipt->OwnerData->UserData->name;
    }

    return [
        'msg' => __('Receipt Number') . ' ' . ($this->newReceipt->receipt_id) . ' ' . __('By') . ' ' . $client_name,
        'url' => route('Admin.Receipt.show', $this->newReceipt->id),
            'type_noty' => 'New receipt attached',
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
