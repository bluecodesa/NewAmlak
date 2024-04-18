<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SubscriptionHistoryRepositoryInterface;
use App\Models\SubscriptionHistory;
use App\Models\SubscriptionType;

class SubscriptionHistoryRepository implements SubscriptionHistoryRepositoryInterface
{


    public function create($brokerId, $officeId, $subscriptionTypeId)
    {
        return
        SubscriptionHistory::create([
            'broker_id' => $brokerId,
            'office_id' => $officeId,
            'subscription_type_id' => $subscriptionTypeId,
            'status' => 'active',
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => SubscriptionType::find($subscriptionTypeId)->calculateEndDate(now())->format('Y-m-d H:i:s')
        ]);
    }
    public function find(int $id)
    {
        return SubscriptionHistory::find($id);
    }

    public function update(int $id, array $data)
    {
        $subscriptionHistory = SubscriptionHistory::find($id);
        if ($subscriptionHistory) {
            $subscriptionHistory->update($data);
            return $subscriptionHistory;
        }
        return null;
    }

    public function delete(int $id)
    {
        $subscriptionHistory = SubscriptionHistory::find($id);
        if ($subscriptionHistory) {
            $subscriptionHistory->delete();
            return true;
        }
        return false;
    }

    public function getAll()
    {
        return SubscriptionHistory::all();
    }
}
