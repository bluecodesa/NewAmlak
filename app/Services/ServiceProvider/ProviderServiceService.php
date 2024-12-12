<?php

namespace App\Services\ServiceProvider;

use App\Interfaces\ServiceProvider\ProviderServiceRepositoryInterface;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProviderServiceService
{
    protected $ProviderServiceRepository;

    public function __construct(ProviderServiceRepositoryInterface $ProviderServiceRepository)
    {
        $this->ProviderServiceRepository = $ProviderServiceRepository;
    }

    public function getAll()
    {
        return $this->ProviderServiceRepository->getAll();
    }

    public function getAllByServiceProviderId($serviceProviderId)
    {
        return $this->ProviderServiceRepository->getAllByServiceProviderId($serviceProviderId);
    }

    function getById($id)
    {
        return $this->ProviderServiceRepository->getById($id);
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
        return $this->ProviderServiceRepository->create($data);
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
        return $this->ProviderServiceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->ProviderServiceRepository->delete($id);
    }
}
