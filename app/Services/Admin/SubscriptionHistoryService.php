<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SubscriptionHistoryRepositoryInterface;



class SubscriptionHistoryService
{
    protected $subscriptionHistoryRepository;

    public function __construct(SubscriptionHistoryRepositoryInterface $subscriptionHistoryRepository)
    {
        $this->subscriptionHistoryRepository = $subscriptionHistoryRepository;
    }

    public function create($brokerId, $officeId, $subscriptionTypeId)
    {
        return $this->subscriptionHistoryRepository->create($brokerId, $officeId, $subscriptionTypeId);
    }

    public function find(int $id)
    {
        return $this->subscriptionHistoryRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->subscriptionHistoryRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->subscriptionHistoryRepository->delete($id);
    }

    public function getAll()
    {
        return $this->subscriptionHistoryRepository->getAll();
    }
}
