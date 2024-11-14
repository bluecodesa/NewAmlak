<?php

namespace App\Notifications\Admin;

use App\Models\Broker;
use App\Models\Subscription;
use App\Models\realEstateRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRealEstateRequestNotification extends Notification
{
    use Queueable;


    private $realEstateRequest;
    private $user;



    public function __construct(RealEstateRequest $realEstateRequest, User $user)
{
    $this->realEstateRequest = $realEstateRequest;
    $this->user = $user;
}


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $realEstateRequest_id=$this->realEstateRequest->id;
        if($this->user->UserBrokerData){
            $url='Broker.RealEstateRequest.show';
        }elseif($this->user->UserOfficeData){
            $url='Office.RealEstateRequest.show';
        }
        $realEstateRequest=RealEstateRequest::where('id',$realEstateRequest_id)->first();
        return [
            'msg' => __('') . ' ' . 'مطلوب '.($realEstateRequest->propertyType->name).' بمدينة '.($realEstateRequest->city->name).'-'.'  رقم الطلب '.($realEstateRequest->number_of_requests) ,
            'url' => route($url, $realEstateRequest->id),
            'type_noty' => 'New Real Estate Request',
            'service_name' => 'NewRealEstateRequest',
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
