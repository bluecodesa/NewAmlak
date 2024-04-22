<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SubscriptionTypeRepositoryInterface;
use App\Models\SubscriptionType;
use App\Models\SubscriptionTypeRole;
use App\Models\SubscriptionTypeSection;

class SubscriptionTypeRepository implements SubscriptionTypeRepositoryInterface
{
    public function getAll()
    {
        $query = SubscriptionType::where('is_deleted', 0)->where('is_show', 1);
        return $query->get();
    }
    public function getAllFiltered($status, $period, $price)
    {
        $query = SubscriptionType::where('is_deleted', 0);

        if (!is_null($status) && $status != 'all') {
            $query->where('status', $status);
        }

        if (!is_null($period) && $period != 'all') {
            $query->where('period_type', $period);
        }

        if (!is_null($price) && $price != 'all') {
            $query = $price == 0 ? $query->where('price', '=', 0) : $query->where('price', '<=', $price);
        }

        return $query->get();
    }

    public function create($data)
    {
        $data = request();
        $Subscriptiondata = $data->except(['roles', 'sections']);
        $Subscriptiondata['upgrade_rate'] =  $data['upgrade_rate'] / 100;
        $subscriptionType = SubscriptionType::create($Subscriptiondata);

        foreach ($data['sections'] as $section) {
            SubscriptionTypeSection::create(['subscription_type_id' => $subscriptionType->id, 'section_id' => $section]);
        }

        foreach ($data['roles'] as $role) {
            SubscriptionTypeRole::create(['subscription_type_id' => $subscriptionType->id, 'role_id' => $role]);
        }

        return $subscriptionType;
    }

    public function findById($id)
    {
        return SubscriptionType::find($id);
    }

    public function update($id, $data)
    {
        $subscriptionType = SubscriptionType::find($id);
        $data = request();
        $Subscriptiondata = $data->except(['roles', 'sections']);
        $Subscriptiondata['upgrade_rate'] =  $data['upgrade_rate'] / 100;
        $subscriptionType->update($Subscriptiondata);

        // Sync sections
        $subscriptionType->sections()->sync($data['sections']);

        // Sync roles
        $subscriptionType->roles()->sync($data['roles']);

        return $subscriptionType;
    }

    public function delete($id)
    {
        SubscriptionType::where('id', $id)->update(['is_deleted' => 1]);
    }
    public function getUserSubscriptionTypes()
    {
        return SubscriptionType::where('is_deleted', 0)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'RS-Broker');
            })
            ->where('price', '>', 0)
            ->get();
    }

    public function getSubscriptionTypesForOffice()
    {
        return SubscriptionType::where('is_deleted', 0)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Office-Admin');
            })
            ->get();
    }

    public function getSubscriptionTypesForBroker()
    {
        return SubscriptionType::where('is_deleted', 0)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'RS-Broker');
            })
            ->get();
    }
}
