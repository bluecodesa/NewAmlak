<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SubscriptionTypeRepositoryInterface;

class SubscriptionTypeService
{
    protected $subscriptionTypeRepository;

    public function __construct(SubscriptionTypeRepositoryInterface $subscriptionTypeRepository)
    {
        $this->subscriptionTypeRepository = $subscriptionTypeRepository;
    }

    public function getAllFiltered($status, $period, $price)
    {
        return $this->subscriptionTypeRepository->getAllFiltered($status, $period, $price);
    }

    public function createSubscriptionType($data)
    {
        return $this->subscriptionTypeRepository->create($data);
    }

    public function getSubscriptionTypeById($id)
    {
        return $this->subscriptionTypeRepository->findById($id);
    }

    public function updateSubscriptionType($id, $data)
    {
        return $this->subscriptionTypeRepository->update($id, $data);
    }

    public function deleteSubscriptionType($id)
    {
        return $this->subscriptionTypeRepository->delete($id);
    }

    public function getUserSubscriptionTypes()
    {
        return $this->subscriptionTypeRepository->getUserSubscriptionTypes();
    }
}
