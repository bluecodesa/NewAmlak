<?php


namespace App\Interfaces\Broker;

interface AdvisorRepositoryInterface
{
    public function getAllAdvisorsForBroker($brokerId);

    public function createAdvisor($data);

    public function getAdvisorById($id);

    public function updateAdvisor($id, $data);

    public function deleteAdvisor($id);
}
