<?php

namespace App\Repositories\Admin;

use App\Models\Subscription;
use App\Interfaces\Admin\SubscriptionRepositoryInterface;
use App\Models\User;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function getAllSubscribers()
    {
        return Subscription::with(['OfficeData.UserData', 'BrokerData.UserData','OwnerData.UserData', 'SubscriptionTypeData'])->orderBy('updated_at', 'desc')->paginate(100);
    }

    public function getAllUsers()
    {
        return User::where('is_admin',0)->orderBy('updated_at', 'desc')->paginate(20);
    }

    public function findSubscriberById(int $id)
    {
        return Subscription::find($id);
    }
    public function findUserById(int $id)
    {
        return User::find($id);
    }

    public function createOfficeSubscriber(array $data)
    {
        return Subscription::create($data);
    }

    public function createBrokerSubscriber(array $data)
    {
        return Subscription::create($data);
    }

    public function updateSubscriber(int $id, array $data)
    {
        $subscription = Subscription::find($id);
        $subscription->update($data);
        return $subscription;
    }

    public function deleteSubscriber(int $id)
    {
        // $subscription =  Subscription::findOrFail($id);

        // if ($subscription->OfficeData) {
        //     $subscription->OfficeData->UserData()->delete();
        // } else {
        //     $subscription->BrokerData->UserData()->delete();
        // }
        return User::destroy($id);
    }


    public function suspendSubscription($id, $isSuspend)
    {
        Subscription::find($id)->update([
            'is_suspend' => $isSuspend,
        ]);
    }

    public function findSubscriptionByBrokerId($brokerId)
    {
        return Subscription::where('broker_id', $brokerId)->first();
    }
    public function findSubscriptionByOfficeId($officeId)
    {
        return Subscription::where('office_id', $officeId)->first();
    }
}
