<?php


// app/Http/Controllers/Office/ProjectManagement/ProjectController.php

namespace App\Http\Controllers\Employee\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\Employee\OfficeDataService;
use App\Services\Employee\ProjectService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use Illuminate\Http\Request;
use App\Services\Admin\ProjectService as AdminProjectService;
use App\Services\ServiceTypeService;
use App\Services\AllServiceService;
use App\Services\FeatureService;






class ProjectController extends Controller
{
    protected $projectService;
    protected $regionService;
    protected $cityService;
    protected $officeDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $AdminProjectService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;






    public function __construct(ProjectService $projectService, RegionService $regionService,
    CityService $cityService, OfficeDataService $officeDataService, PropertyTypeService $propertyTypeService,
     PropertyUsageService $propertyUsageService,
     AdminProjectService $AdminProjectService,
     ServiceTypeService $ServiceTypeService,
     AllServiceService $AllServiceService,
     FeatureService $FeatureService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->projectService = $projectService;
        $this->officeDataService = $officeDataService;
        $this->projectService = $projectService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->AdminProjectService = $AdminProjectService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;




        $this->middleware(['role_or_permission:read-project'])->only(['index']);
        $this->middleware(['role_or_permission:create-project'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-project'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-project'])->only(['destroy']);

    }

    public function index()
    {
        $Projects = $this->projectService->getAllProjectsByOfficeId(auth()->user()->UserEmployeeData->OfficeData->id);
        return view('Office.Employee.ProjectManagement.Project.index', get_defined_vars());
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $employees = $this->officeDataService->getEmployees();
        $projectStatuses = $this->AdminProjectService->getAllProjectStatus();
        $deliveryCases = $this->AdminProjectService->getAllDeliveryCases();
        $services = $this->ServiceTypeService->getAllServiceTypes();

        return view('Office.Employee.ProjectManagement.Project.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $images = $request->image;
        $this->projectService->createProject($request->except('image'), $images);
        return redirect()->route('Employee.Project.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $project = $this->projectService->ShowProject($id);
        return view('Office.Employee.ProjectManagement.Project.show', get_defined_vars());
    }

    public function edit($id)
    {
        $project = $this->projectService->findProjectById($id);
        $Regions = $this->regionService->getAllRegions();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $employees = $this->officeDataService->getEmployees();
        $projectStatuses = $this->AdminProjectService->getAllProjectStatus();
        $deliveryCases = $this->AdminProjectService->getAllDeliveryCases();
        return view('Office.Employee.ProjectManagement.Project.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $images = $request->image;
        $this->projectService->updateProject($id, $request->except('image'), $images);
        return redirect()->route('Employee.Project.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->projectService->deleteProject($id);
        return redirect()->route('Employee.Project.index')->with('success', __('Deleted successfully'));
    }

    public function createProperty($id)
    {
        $project = $this->projectService->findProjectById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $employees = $this->officeDataService->getEmployees();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        return view('Office.Employee.ProjectManagement.Project.CreateProperty', get_defined_vars());
    }

    // public function storeProperty(Request $request, $id)
    // {
    //     $rules = [
    //         'name' => 'required|string|max:255',
    //         'location' => 'required|string|max:255',
    //         'city_id' => 'required|exists:cities,id',
    //         'property_type_id' => 'required|exists:property_types,id',
    //         'property_usage_id' => 'required|exists:property_usages,id',
    //         'employee_id' => 'required|exists:employees,id',
    //         'owner_id' => 'required|exists:owners,id',
    //     ];
    //     $request->validate($rules);
    //     $request_data = $request->except('images');
    //     $request_data['office_id'] = Auth::user()->UserOfficeData->id;
    //     $request_data['project_id'] = $id;

    //     $Property = Property::create($request_data);
    //     if ($request->images) {
    //         foreach ($request->images as  $item) {
    //             $ext  =  uniqid() . '.' . $item->clientExtension();
    //             $item->move(public_path() . '/Offices/Projects/Property/', $ext);
    //             $request_image['image'] = '/Offices/Projects/Property/' .  $ext;
    //             $request_image['property_id'] = $Property->id;
    //             PropertyImage::create($request_image);
    //         }
    //     }
    //     return redirect()->route('Office.Project.show', $id)->with('success', __('added successfully'));
    // }

    public function storeProperty(Request $request, $id)
    {
        $images = $request->file('images');
        $this->projectService->storeProperty($request->except('images'), $id, $images);
        return redirect()->route('Employee.Project.show', $id)->with('success', __('added successfully'));
    }
    function CreateUnitFromProject($id)
    {
        $Project = $this->projectService->findProjectById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        return view('Office.Employee.ProjectManagement.Project.CreateUnit', get_defined_vars());
    }

    function StoreUnit(Request $request, $id)
    {
        $this->projectService->StoreUnit($id, $request->all());
        return redirect()->route('Broker.Project.show', $id)->with('success', __('added successfully'));
    }

    public function autocomplete(Request $request)
    {
        $data = $this->projectService->autocomplete($request->all());
        return response()->json($data);
    }
}
