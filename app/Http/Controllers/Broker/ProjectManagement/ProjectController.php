<?php


namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\CityService;
use App\Services\Broker\BrokerDataService;
use App\Services\Broker\ProjectService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    protected $projectService;
    protected $regionService;
    protected $cityService;
    protected $brokerDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;


    public function __construct(ProjectService $projectService, RegionService $regionService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->projectService = $projectService;
        $this->brokerDataService = $brokerDataService;
        $this->projectService = $projectService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
    }

    public function index()
    {
        // return   $subscriptions = Subscription::whereDate('end_date', '<=', now()->format('Y-m-d'))->get();
        $Projects = $this->projectService->getAllProjectsByBrokerId(auth()->user()->UserBrokerData->id);
        return view('Broker.ProjectManagement.Project.index',  get_defined_vars());
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        return view('Broker.ProjectManagement.Project.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $images = $request->image;
        $this->projectService->createProject($request->except('image'), $images);
        return redirect()->route('Broker.Project.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $project = $this->projectService->ShowProject($id);
        return view('Broker.ProjectManagement.Project.show',  get_defined_vars());
    }

    public function edit($id)
    {
        $project = $this->projectService->findProjectById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        return view('Broker.ProjectManagement.Project.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $images = $request->image;
        $this->projectService->updateProject($id, $request->except('image'), $images);
        return redirect()->route('Broker.Project.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->projectService->deleteProject($id);
        return redirect()->route('Broker.Project.index')->with('success', __('Deleted successfully'));
    }

    public function createProperty($id)
    {
        $project = $this->projectService->findProjectById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        return view('Broker.ProjectManagement.Project.CreateProperty', get_defined_vars());
    }

    public function storeProperty(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'property_type_id' => 'required|exists:property_types,id',
            'property_usage_id' => 'required|exists:property_usages,id',
            'owner_id' => 'required|exists:owners,id',
            'instrument_number' => [
                'nullable',
                Rule::unique('properties'),
                'max:25'
            ],
        ];
        $request->validate($rules);

        $images = $request->file('images');
        $this->projectService->storeProperty($request->except('images'), $id, $images);
        return redirect()->route('Broker.Project.show', $id)->with('success', __('added successfully'));
    }

    function deleteImage($id)
    {
        $project = $this->projectService->findProjectById($id);
        $project->update(['image' => '/Brokers/Projects/default.jpg']);
    }
}
