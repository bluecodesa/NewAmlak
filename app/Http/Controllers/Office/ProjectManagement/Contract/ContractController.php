<?php

namespace App\Http\Controllers\Office\ProjectManagement\Contract;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\OwnerService;
use App\Services\RegionService;
use App\Services\Admin\SettingService;
use App\Services\AllServiceService;
use App\Services\Office\OfficeDataService;
use App\Services\Office\UnitInterestService;
use App\Services\Office\UnitService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\ServiceTypeService;
use App\Services\Office\EmployeeService;
use App\Services\Office\RenterService;



class ContractController extends Controller
{

    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $officeDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;
    protected $OwnerService;
    protected $settingService;
    protected $unitInterestService;
    protected $SubscriptionTypeService;

    protected $subscriptionService;
    protected $EmployeeService;
    protected $RenterService;


    public function __construct(
        SettingService $settingService,
        OwnerService $OwnerService,
        UnitService $UnitService,
        RegionService $regionService,
        AllServiceService $AllServiceService,
        FeatureService $FeatureService,
        CityService $cityService,
        OfficeDataService $officeDataService,
        PropertyTypeService $propertyTypeService,
        ServiceTypeService $ServiceTypeService,
        PropertyUsageService $propertyUsageService,
        UnitInterestService $unitInterestService,
        EmployeeService $EmployeeService,
        RenterService $RenterService
    )
    {
        $this->OwnerService = $OwnerService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->UnitService = $UnitService;
        $this->officeDataService = $officeDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;
        $this->settingService = $settingService;
        $this->unitInterestService = $unitInterestService;
        $this->EmployeeService = $EmployeeService;
        $this->RenterService = $RenterService;

    }

    public function index()
    {
        $owners = $this->OwnerService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        $contracts=[];
        return view('Office.Contract.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        $employees = $this->EmployeeService->getAllByOfficeId(auth()->user()->UserOfficeData->id);

        $office_id = auth()->user()->UserOfficeData->id;
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $projects=Project::where('office_id',$office_id)->get();
        $properties=Property::where('office_id',$office_id)->get();
        $units=Unit::where('office_id',$office_id)->get();
        $renters = $this->RenterService->getAllByOfficeId($office_id);
        $owners = $this->OwnerService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.Contract.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->OwnerService->createOwner($request->all());
        return redirect()->route('Office.Owner.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $Owner =  $this->OwnerService->getOwnerById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Owner.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->OwnerService->updateOwner($id, $request->all());
        return redirect()->route('Office.Owner.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->OwnerService->deleteOwner($id);
        return redirect()->route('Office.Owner.index')->with('success', __('Deleted successfully'));
    }

    public function getProjectDetails(Project $project)
    {
        $properties = $project->PropertiesProject;
        $units = $project->UnitsProject;

        return response()->json([
            'properties' => $properties,
            'units' => $units
        ]);
    }
    public function getUnitsByProperty(Property $property)
    {
        // Fetch units associated with the property
        $units = $property->PropertyUnits;

        // Return the data as a JSON response
        return response()->json([
            'units' => $units
        ]);
    }
}
