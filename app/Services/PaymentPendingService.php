<?php
// app/Services/PaymentPendingService.php

namespace App\Services;

use App\Models\City;
use App\Models\SubscriptionType;
use Illuminate\Support\Facades\Auth;

class PaymentPendingService
{
    public function UserPendingPayment()
    {
        $user = Auth::user();
        $userSubscriptionTypes = null;
        // dd( $pendingPayment =  Auth::user()->UserOfficeData->UserSubscriptionPending);

        if ($user->is_office && $user->UserOfficeData) {
            $pendingPayment = $user->UserOfficeData->UserSubscriptionPending ?? false;
            $subscription = $user->UserOfficeData->UserSubscriptionPending ?? false;
            $roleName = 'Office-Admin';
        } elseif ($user->is_broker && $user->UserBrokerData) {
            $pendingPayment = $user->UserBrokerData->UserSubscriptionPending ?? false;
            $subscription = $user->UserBrokerData->UserSubscriptionPending ?? false;
            $roleName = 'RS-Broker';
        }

        if ($roleName) {
            $userSubscriptionTypes = SubscriptionType::where('is_deleted', 0)
            ->whereHas('roles', function ($query) use ($roleName) {
                $query->where('name', $roleName);
            })
            ->where('price', '>', 0)
            ->get();

        }

        return  get_defined_vars();
    }

}
