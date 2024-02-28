<?php


namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\Broker\BrokerDataService;
use App\Services\Broker\PropertyService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;


class UnitController extends Controller
{
    protected $PropertyService;
    protected $regionService;
    protected $cityService;
    protected $brokerDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;


    public function __construct(PropertyService $PropertyService, RegionService $regionService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->PropertyService = $PropertyService;
        $this->brokerDataService = $brokerDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
    }

    public function index()
    {
        $properties = $this->PropertyService->getAll(auth()->user()->UserBrokerData->id);
        return view('Broker.ProjectManagement.Project.Property.index',  get_defined_vars());
    }

    public function create()
    {
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        return view('Broker.ProjectManagement.Project.Property.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $images = $request->file('images');
        $this->PropertyService->store($request->except('images'), $images);
        return redirect()->route('Broker.Property.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $Property = $this->PropertyService->findById($id);
        return view('Broker.ProjectManagement.Project.Property.show',  get_defined_vars());
    }

    public function edit($id)
    {
        $Property = $this->PropertyService->findById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        return view('Broker.ProjectManagement.Project.Property.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $images = $request->image;
        $this->PropertyService->update($id, $request->except('image'), $images);
        return redirect()->route('Broker.Property.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->PropertyService->delete($id);
        return redirect()->route('Broker.Property.index')->with('success', __('Deleted successfully'));
    }
}