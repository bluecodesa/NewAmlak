<?php



namespace App\Interfaces\Admin;

use App\Models\Subscription;

interface SubscriptionRepositoryInterface
{

    public function getAllSubscribers();


    public function findSubscriberById(int $id);


    public function createOfficeSubscriber(array $data);

    public function createBrokerSubscriber(array $data);


    public function updateSubscriber(int $id, array $data);


    public function deleteSubscriber(int $id);
}
