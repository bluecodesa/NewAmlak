<?php

namespace App\Repositories\Admin;

use App\Models\Subscription;
use App\Interfaces\Admin\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function getAllSubscribers()
    {
        return Subscription::with(['OfficeData.UserData', 'BrokerData.UserData'])->get();
    }

    public function findSubscriberById(int $id)
    {
        return Subscription::find($id);
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
        return Subscription::findOrFail($id)->delete();;
    }


    public function suspendSubscription($id, $isSuspend)
    {
        Subscription::find($id)->update([
            'is_suspend' => $isSuspend,
        ]);
    }
}
