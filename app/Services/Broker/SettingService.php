<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\SettingRepositoryInterface;
use App\Models\Broker;

class SettingService
{
    protected $brokerSettingRepository;

    public function __construct(SettingRepositoryInterface $brokerSettingRepository)
    {
        $this->brokerSettingRepository = $brokerSettingRepository;
    }

    public function getBrokerSettings(Broker $broker)
    {

        return $this->brokerSettingRepository->getBrokerSettings($broker);

    }

    public function updateBroker(array $data, Broker $broker)
    {
        return $this->brokerSettingRepository->updateBroker($data, $broker);
    }
}
