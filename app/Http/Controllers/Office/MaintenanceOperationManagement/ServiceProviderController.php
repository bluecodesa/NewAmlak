<?php

namespace App\Http\Controllers\Office\MaintenanceOperationManagement;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProviderServiceService;
use App\Services\CityService;
use App\Services\Office\AdvisorService;
use App\Services\Office\ServiceProviderService;
use App\Services\RegionService;
use App\Services\ServiceProvider\ProviderServiceService as ServiceProviderProviderServiceService;
use Illuminate\Http\Request;
use App\Models\Office;


class ServiceProviderController extends Controller
{
    protected $ProviderServiceServiceType;
    protected $ServiceProviderService;

    protected $regionService;
    protected $cityService;

    public function __construct(ProviderServiceService $ProviderServiceServiceType
    ,ServiceProviderService $ServiceProviderService, RegionService $regionService, CityService $cityService)
    {
        $this->ProviderServiceServiceType = $ProviderServiceServiceType;
        $this->ServiceProviderService = $ServiceProviderService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        // $serviceProviders = $this->ServiceProviderService->getAll();
        $officeId =auth()->user()->UserOfficeData->id;
        $office = Office::find($officeId);
        $serviceProviders = $office->serviceProviders;
        return view('Office.MaintenanceOperationManagement.ServiceProvider.index', get_defined_vars());
    }

    public function create()
    {
        $providerServiceTypes = $this->ProviderServiceServiceType->getAll();
        return view('ServiceProvider.MaintenanceOperationManagement.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->ProviderServiceService->create($request->all());
        return redirect()->route('ServiceProvider.ProviderService.index')->with('success', __('Added successfully'));
    }

    public function edit($id)
    {
        $providerServiceTypes = $this->ProviderServiceServiceType->getAll();

        $providerService = $this->ProviderServiceService->getById($id);
        return view('ServiceProvider.MaintenanceOperationManagement.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->ProviderServiceService->update($id, $request->all());
        return redirect()->route('ServiceProvider.ProviderService.index')->with('success', __('Updated successfully'));
    }

    public function destroy($id)
    {
        $this->ProviderServiceService->delete($id);
        return redirect()->route('ServiceProvider.ProviderService.index')->with('success', __('Deleted successfully'));
    }
}
