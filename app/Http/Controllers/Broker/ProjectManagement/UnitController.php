<?php


namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\PropertyUsage;
use App\Models\Unit;
use App\Models\UnitInterest;
use App\Services\Admin\SettingService;
use App\Services\AllServiceService;
use App\Services\CityService;
use App\Services\Broker\BrokerDataService;
use App\Services\Broker\OwnerService;
use App\Services\Broker\UnitInterestService;
use App\Services\Broker\UnitService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;

class UnitController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $brokerDataService;
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




    public function __construct(
        SettingService $settingService,
        OwnerService $ownerService,
        UnitService $UnitService,
        RegionService $regionService,
        AllServiceService $AllServiceService,
        FeatureService $FeatureService,
        CityService $cityService,
        BrokerDataService $brokerDataService,
        PropertyTypeService $propertyTypeService,
        ServiceTypeService $ServiceTypeService,
        PropertyUsageService $propertyUsageService,
        UnitInterestService $unitInterestService,
        SubscriptionTypeService $SubscriptionTypeService,
        SubscriptionService $subscriptionService
    ) {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->UnitService = $UnitService;
        $this->brokerDataService = $brokerDataService;
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
        //
        $this->middleware(['role_or_permission:read-unit'])->only(['show']);
        $this->middleware(['role_or_permission:read-all-units'])->only(['index']);
        $this->middleware(['role_or_permission:create-unit'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-unit'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-unit'])->only(['destroy']);
    }

    public function index(Request $request)
    {

        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);

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

        return view('Broker.ProjectManagement.Project.Unit.index',  get_defined_vars());
    }

    function IndexByStatus($type)
    {
        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        $units = $units->where('status', $type);

        return view('Broker.ProjectManagement.Project.Unit.index', get_defined_vars());
    }

    function IndexByUsage($usage)
    {
        $units = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        if ($usage == '5') {
            $units = $units->where('property_usage_id', '!=', $usage);
        } else {

            $units = $units->where('property_usage_id', $usage);
        }
        $usage = PropertyUsage::find($usage);
        return view('Broker.ProjectManagement.Project.Unit.index', get_defined_vars());
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
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        return view('Broker.ProjectManagement.Project.Unit.create', get_defined_vars());
    }

    function SaveNewOwners(Request $request)
    {
        $this->ownerService->createOwner($request->all());
        $owners = $this->brokerDataService->getOwners();
        return view('Broker.ProjectManagement.Project.Unit.inc._owners', compact('owners'));
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
        return redirect()->route('Broker.Unit.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $Unit = $this->UnitService->findById($id);
        $brokerId = auth()->user()->UserBrokerData->id;
        $subscription = $this->subscriptionService->findSubscriptionByBrokerId($brokerId);
        if ($subscription) {
            $sectionsIds = auth()->user()
                ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
                ->toArray();
            if (in_array(18, $sectionsIds)) {
                $unitInterests = $this->unitInterestService->getUnitInterestsByUnitId($id);
                $interestsTypes = $this->settingService->getAllInterestTypes();
            }
        }
        if (auth()->user()->UserBrokerData->id === $Unit->broker_id) {
            return view('Broker.ProjectManagement.Project.Unit.show', get_defined_vars());
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
        $advisors = $this->brokerDataService->getAdvisors();
        $developers = $this->brokerDataService->getDevelopers();
        $owners = $this->brokerDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        return view('Broker.ProjectManagement.Project.Unit.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $Unit = $this->UnitService->findById($id);
        $this->UnitService->update($id, $request->all());
        if ($Unit->property_id != null) {
            return redirect()->route('Broker.Property.show', $Unit->property_id)->with('success', __('Update successfully'));
        }
        return redirect()->route('Broker.Unit.show', $Unit->id)->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->UnitService->delete($id);
        return redirect()->route('Broker.Unit.index')->with('success', __('Deleted successfully'));
    }

    public function destroyUnitGallery(string $id)
    {
        $this->UnitService->delete($id);
        return redirect()->route('Broker.Gallery.index')->with('success', __('Deleted successfully'));
    }

    function deleteImage($id)
    {
        $unit = $this->UnitService->findById($id);
        $unit->UnitImages[0]->update(['image' => '/Brokers/Projects/default.jpg']);
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
}
