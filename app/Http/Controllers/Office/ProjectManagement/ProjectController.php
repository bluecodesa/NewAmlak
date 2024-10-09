<?php


// app/Http/Controllers/Office/ProjectManagement/ProjectController.php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\FalLicenseUser;
use App\Services\CityService;
use App\Services\Office\OfficeDataService;
use App\Services\Office\ProjectService;
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
        $Projects = $this->projectService->getAllProjectsByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Project.index', get_defined_vars());
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
        $falLicense = FalLicenseUser::where('user_id', auth()->id())
        ->whereHas('falData', function ($query) {
            $query->where('for_gallery', 1);

        })
        ->where('ad_license_status', 'valid')
        ->first();
        $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;

        return view('Office.ProjectManagement.Project.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $files = [
            'images' => $request->file('images'),
            'project_masterplan' => $request->file('project_masterplan'),
            'project_brochure' => $request->file('project_brochure')
        ];

        $this->projectService->createProject($request->except(['image', 'project_masterplan', 'project_brochure']), $files);
       return redirect()->route('Office.Project.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $project = $this->projectService->ShowProject($id);
        return view('Office.ProjectManagement.Project.show', get_defined_vars());
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
        $falLicense = FalLicenseUser::where('user_id', auth()->id())
        ->whereHas('falData', function ($query) {
            $query->where('for_gallery', 1);

        })
        ->where('ad_license_status', 'valid')
        ->first();
        $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;
        return view('Office.ProjectManagement.Project.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $images = $request->images;
        $this->projectService->updateProject($id, $request->except('images'), $images);
        return redirect()->route('Office.Project.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->projectService->deleteProject($id);
        return redirect()->route('Office.Project.index')->with('success', __('Deleted successfully'));
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
        return view('Office.ProjectManagement.Project.CreateProperty', get_defined_vars());
    }


    public function storeProperty(Request $request, $id)
    {
        $images = $request->file('images');
        $this->projectService->storeProperty($request->except('images'), $id, $images);
        return redirect()->route('Office.Project.show', $id)->with('success', __('added successfully'));
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
        $employees = $this->officeDataService->getEmployees();
        return view('Office.ProjectManagement.Project.CreateUnit', get_defined_vars());
    }

    function StoreUnit(Request $request, $id)
    {
        $this->projectService->StoreUnit($id, $request->all());
        return redirect()->route('Office.Project.show', $id)->with('success', __('added successfully'));
    }

    public function autocomplete(Request $request)
    {
        $data = $this->projectService->autocomplete($request->all());
        return response()->json($data);
    }
}
