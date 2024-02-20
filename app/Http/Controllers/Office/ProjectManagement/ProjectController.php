<?php


// app/Http/Controllers/Office/ProjectManagement/ProjectController.php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\Office\OfficeDataService;
use App\Services\Office\ProjectService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    protected $projectService;
    protected $regionService;
    protected $cityService;
    protected $officeDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    public function __construct(ProjectService $projectService, RegionService $regionService, CityService $cityService, OfficeDataService $officeDataService, PropertyTypeService $propertyTypeService, PropertyUsageService $propertyUsageService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->projectService = $projectService;
        $this->officeDataService = $officeDataService;
        $this->projectService = $projectService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
    }

    public function index()
    {
        $Projects = $this->projectService->getAllProjectsByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Project.index', compact('Projects'));
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $employees = $this->officeDataService->getEmployees();
        return view('Office.ProjectManagement.Project.create', compact('Regions', 'cities', 'advisors', 'developers', 'owners', 'employees'));
    }

    public function store(Request $request)
    {
        $images = $request->image;
        $this->projectService->createProject($request->except('image'), $images);
        return redirect()->route('Office.Project.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $project = $this->projectService->ShowProject($id);
        return view('Office.ProjectManagement.Project.show', compact('project'));
    }

    public function edit($id)
    {
        $project = $this->projectService->findProjectById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $employees = $this->officeDataService->getEmployees();
        return view('Office.ProjectManagement.Project.edit', compact('project', 'Regions', 'cities', 'advisors', 'developers', 'owners', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $images = $request->image;
        $this->projectService->updateProject($id, $request->except('image'), $images);
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
        return view('Office.ProjectManagement.Project.CreateProperty', compact('project', 'Regions', 'cities', 'types', 'usages', 'developers', 'owners', 'employees'));
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
        return redirect()->route('Office.Project.show', $id)->with('success', __('added successfully'));
    }
}
