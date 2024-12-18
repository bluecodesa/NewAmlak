<?php

namespace App\Repositories\Office;

use App\Models\Advisor;
use App\Interfaces\Office\ServiceProviderRepositoryInterface;
use App\Models\ProviderService;

class ServiceProviderRepository implements ServiceProviderRepositoryInterface
{
    public function getAll()
    {
        return ProviderService::all();
    }
    public function getAllByServiceProviderId($serviceProviderId)
    {
        return ProviderService::where('service_provider_id', $serviceProviderId)->get();
    }

    public function create($data)
    {
        return ProviderService::create($data);
    }

    function getById($id)
    {
        return ProviderService::find($id);
    }

    public function update($id, $data)
    {
        $advisor = ProviderService::findOrFail($id);
        $advisor->update($data);
        return $advisor;
    }

    public function delete($id)
    {
        return ProviderService::findOrFail($id)->delete();
    }
}
