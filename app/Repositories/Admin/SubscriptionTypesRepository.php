<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SubscriptionTypesRepositoryInterface;
use App\Models\subscription;
use App\Models\SubscriptionType;
use App\Services\Admin\SubscriptionTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionTypesRepository implements SubscriptionTypesRepositoryInterface
{
    protected $subscriptionTypeService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService)
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
    }

    public function calculateRange($counts)
    {
        return $this->subscriptionTypeService->calculateRange($counts);
    }

    public function index($status_filter, $period_filter, $price_filter)
    {
        return $this->subscriptionTypeService->index($status_filter, $period_filter, $price_filter);
    }

    public function create()
    {
        return $this->subscriptionTypeService->create();
    }

    public function store(Request $request)
    {
        return $this->subscriptionTypeService->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->subscriptionTypeService->update($request, $id);
    }


    public function edit($id)
    {
        return $this->subscriptionTypeService->edit($id);
    }

    public function find($id)
    {
        return $this->subscriptionTypeService->find($id);
    }

    public function getBy($arr)
    {
        return $this->subscriptionTypeService->getBy($arr);
    }


    public  function getAll()
    {
        return $this->subscriptionTypeService->getAll();
    }


    public function deleteMultiType($array)
    {
        return $this->subscriptionTypeService->deleteMultiType($array);
    }

    public function deleteType($id)
    {
        return $this->subscriptionTypeService->deleteType($id);
    }
}
