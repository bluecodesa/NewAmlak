<?php

namespace App\Services\Broker;

use App\Repositories\Broker\DeveloperRepository;

class DeveloperService
{
    protected $developerRepository;

    public function __construct(DeveloperRepository $developerRepository)
    {
        $this->developerRepository = $developerRepository;
    }

    public function getAllDevelopersByBrokerId($brokerId)
    {
        return $this->developerRepository->getAllByBrokerId($brokerId);
    }

    public function createDeveloper($data)
    {
        return $this->developerRepository->create($data);
    }

    public function getDeveloperById($id)
    {
        return $this->developerRepository->find($id);
    }

    public function updateDeveloper($id, $data)
    {
        return $this->developerRepository->update($id, $data);
    }

    public function deleteDeveloper($id)
    {
        return $this->developerRepository->delete($id);
    }
}