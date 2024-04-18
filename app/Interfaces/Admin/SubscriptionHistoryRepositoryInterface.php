<?php



namespace App\Interfaces\Admin;

interface SubscriptionHistoryRepositoryInterface
{
    public function create($brokerId, $officeId, $subscriptionTypeId);

    public function find(int $id);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getAll();
}
