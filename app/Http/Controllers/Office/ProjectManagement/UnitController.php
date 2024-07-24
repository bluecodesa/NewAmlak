<?php


namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Property;
use App\Models\Unit;
use App\Models\UnitImage;
use App\Models\UnitInterest;
use App\Services\Admin\SettingService;
use App\Services\AllServiceService;
use App\Services\CityService;
use App\Services\Office\OfficeDataService;
use App\Services\Office\OwnerService;
use App\Services\Office\UnitInterestService;
use App\Services\Office\UnitService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Office\EmployeeService;

class UnitController extends Controller
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
    protected $ownerService;
    protected $settingService;
    protected $unitInterestService;
    protected $SubscriptionTypeService;

    protected $subscriptionService;
    protected $EmployeeService;





    public function __construct(
        SettingService $settingService,
        OwnerService $ownerService,
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
        SubscriptionTypeService $SubscriptionTypeService,
        SubscriptionService $subscriptionService,
        EmployeeService $EmployeeService
    ) {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->UnitService = $UnitService;
        $this->officeDataService = $officeDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;
        $this->ownerService = $ownerService;
        $this->settingService = $settingService;
        $this->unitInterestService = $unitInterestService;
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->EmployeeService = $EmployeeService;

        //
        $this->middleware(['role_or_permission:read-unit'])->only(['show']);
        $this->middleware(['role_or_permission:read-all-units'])->only(['index']);
        $this->middleware(['role_or_permission:create-unit'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-unit'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-unit'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $units = $this->UnitService->getAll(auth()->user()->UserOfficeData->id);
             // Apply filters
             if ($request->status) {
                $units = $units->where('status', $request->status);
            }
            if ($request->project) {
                $units = $units->where('project_id', $request->project);
            }
            if ($request->property) {
                $propertyId = (int) $request->property;
                $units = $units->where('property_id', $propertyId);
            }
            if ($request->property_type) {
                $units = $units->where('property_type_id', $request->property_type);
            }
            if ($request->usage) {
                $units = $units->where('property_usage_id', $request->usage);
            }
    
            $projects = $units->pluck('ProjectData')->filter()->unique();
            $properties = $units->pluck('PropertyData')->filter()->unique();
            $propertyTypes = $units->pluck('PropertyTypeData')->filter()->unique();
            $usages = $units->pluck('PropertyUsageData')->filter()->unique();
            $statuses = $units->pluck('status')->unique()->filter();
        $employees = $this->EmployeeService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Project.Unit.index',  get_defined_vars());
    }

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
        $projects = $this->officeDataService->getProjects();
        $properties = $this->officeDataService->getProperties();
        return view('Office.ProjectManagement.Project.Unit.create', get_defined_vars());
    }

    function SaveNewOwners(Request $request)
    {
        $this->ownerService->createOwner($request->all());
        $owners = $this->officeDataService->getOwners();
        return view('Office.ProjectManagement.Project.Unit.inc._owners', compact('owners'));
    }

    public function store(Request $request)
    {
        // return $request;
        $rules = [];
        $rules = [
            'number_unit' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'price' => 'digits_between:0,10',
            'monthly' => 'digits_between:0,8',
            'instrument_number' => [
                'nullable',
                Rule::unique('units'),
                'max:25'
            ],
        ];
        $messages = [
            'number_unit.required' => 'The number unit field is required.',
            'number_unit.string' => 'The number unit must be a string.',
            'number_unit.max' => 'The number unit may not be greater than :max characters.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than :max characters.',
            'city_id.required' => 'The city ID field is required.',
            'city_id.exists' => 'The selected city ID is invalid.',
            'owner_id.required' => 'The owner ID field is required.',
            'owner_id.exists' => 'The selected owner ID is invalid.',
            'instrument_number.unique' => 'The instrument number has already been taken.',
            'instrument_number.max' => 'The instrument number may not be greater than :max characters.',
            'price' => 'price must be smaller than or equal to 10 numbers.',
            'monthly' => 'Monthly price must be smaller than or equal to 8.',


        ];
        $request->validate($rules, $messages);

        $this->UnitService->store($request->all());
        return redirect()->route('Office.Unit.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $Unit = $this->UnitService->findById($id);
        $officeId = auth()->user()->UserOfficeData->id;
        $subscription = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        if ($subscription) {
            $sectionsIds = auth()->user()
                ->UserOfficeData->UserSubscription->SubscriptionSectionData->pluck('section_id')
                ->toArray();
            if (in_array(18, $sectionsIds)) {
                $unitInterests = $this->unitInterestService->getUnitInterestsByUnitId($id);
                $interestsTypes = $this->settingService->getAllInterestTypes();
            }
        }
        if (auth()->user()->UserOfficeData->id === $Unit->office_id) {
            return view('Office.ProjectManagement.Project.Unit.show', get_defined_vars());
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function edit($id)
    {
        $Unit = $this->UnitService->findById($id);
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
        $projects = $this->officeDataService->getProjects();
        $properties = $this->officeDataService->getProperties();
        return view('Office.ProjectManagement.Project.Unit.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $Unit = $this->UnitService->findById($id);
        $this->UnitService->update($id, $request->all());
        if ($Unit->property_id != null) {
            return redirect()->route('Office.Property.show', $Unit->property_id)->with('success', __('Update successfully'));
        }
        return redirect()->route('Office.Unit.show', $Unit->id)->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->UnitService->delete($id);
        return redirect()->route('Office.Unit.index')->with('success', __('Deleted successfully'));
    }

    public function destroyUnitGallery(string $id)
    {
        $this->UnitService->delete($id);
        return redirect()->route('Office.Gallery.index')->with('success', __('Deleted successfully'));
    }

    function deleteImage($id)
    {
        $unit = $this->UnitService->findById($id);
        $unit->UnitImages[0]->update(['image' => '/Offices/Projects/default.jpg']);
    }

    function UpdateRentPriceByType(Request $request, $id)
    {
        // Unit::find($id)->update([
        //     'rent_type_show' => $request->rent_type_show
        // ]);

        $this->UnitService->findById($id)->update([
            'rent_type_show' => $request->rent_type_show
        ]);
    }

    public function getPropertiesByProject($projectId)
    {
        $properties = Property::where('project_id', $projectId)->get();
        return response()->json(['properties' => $properties]);
    }
    public function getPropertyDetail($id)
    {
        $property = Property::findOrFail($id); // Example assuming Property model exists

        return response()->json(['property' => $property]);
    }


    public function getProjectDetails($projectId)
    {
        $project = Project::findOrFail($projectId);
        if ($project) {
            $project->load('CityData','CityData.RegionData', 'CityData.DistrictsCity');
            return response()->json(['project' => $project]);
        } else {
            return response()->json(['error' => 'Project not found'], 404);
        }
    }

    public function getPropertyDetails($propertyId)
    {

        $property = Property::findOrFail($propertyId);

        if ($property) {
            $property->load('CityData','CityData.RegionData', 'CityData.DistrictsCity');

            return response()->json(['property' => $property]);
        } else {
            return response()->json(['error' => 'Property not found'], 404);
        }
    }

    public function destroyImage($id)
    {
        $image = UnitImage::find($id);
        if ($image) {
            $image->delete();
            return response()->json(['success' => 'Image deleted']);
        }
        return response()->json(['error' => 'Image not found'], 404);
    }
    
    public function destroyVideo($id)
    {
        $unit = Unit::find($id);
        if ($unit && $unit->video) {
            $unit->video = null;
            $unit->save();
            return response()->json(['success' => 'Video deleted']);
        }
        return response()->json(['error' => 'Video not found'], 404);
    }
}
