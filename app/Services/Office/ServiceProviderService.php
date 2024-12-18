<?php

namespace App\Services\Office;

use App\Interfaces\Office\ServiceProviderRepositoryInterface;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ServiceProviderService
{
    protected $ServiceProviderRepository;

    public function __construct(ServiceProviderRepositoryInterface $ServiceProviderRepository)
    {
        $this->ServiceProviderRepository = $ServiceProviderRepository;
    }

    public function getAll()
    {
        return $this->ServiceProviderRepository->getAll();
    }

    public function getAllByServiceProviderId($serviceProviderId)
    {
        return $this->ServiceProviderRepository->getAllByServiceProviderId($serviceProviderId);
    }

    function getById($id)
    {
        return $this->ServiceProviderRepository->getById($id);
    }

    public function create($data)
    {
        $data['status'] = isset($data['status']) && $data['status'] === 'on' ? 'active' : 'inactive';

        $rules = [
            'provider_service_type_id' => 'required|exists:provider_service_types,id',
            'price' => 'required|numeric|min:0',
            'description' => 'string',
            'status' => 'required|in:active,inactive',
        ];

        validator($data, $rules)->validate();
        return $this->ServiceProviderRepository->create($data);
    }

    public function update($id, $data)
    {
        $data['status'] = isset($data['status']) && $data['status'] === 'on' ? 'active' : 'inactive';

        $rules = [
            'provider_service_type_id' => 'required|exists:provider_service_types,id',
            'price' => 'required|numeric|min:0',
            'description' => 'string',
            'status' => 'required|in:active,inactive',
        ];




        validator($data, $rules)->validate();
        return $this->ServiceProviderRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->ServiceProviderRepository->delete($id);
    }
}
