<?php

// SubscriptionTypeRepository.php

namespace App\Repositories;

use App\Interfaces\Admin\SubscriptionTypeRepositoryInterface;
use App\Models\SubscriptionType;

class SubscriptionTypeRepository implements SubscriptionTypeRepositoryInterface
{
    public function getAll()
    {
        return SubscriptionType::all();
    }

    public function getById($id)
    {
        return SubscriptionType::findOrFail($id);
    }

    public function create(array $data)
    {
        return SubscriptionType::create($data);
    }

    public function update($id, array $data)
    {
        $subscriptionType = SubscriptionType::findOrFail($id);
        $subscriptionType->update($data);
        return $subscriptionType;
    }

    public function delete($id)
    {
        return SubscriptionType::destroy($id);
    }
}
