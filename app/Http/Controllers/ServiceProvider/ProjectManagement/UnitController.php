<?php


namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\FalLicenseUser;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyService;
use App\Models\PropertyUsage;
use App\Models\Unit;
use App\Models\UnitImage;
use App\Models\UnitInterest;
use App\Services\Admin\FalLicenseService;
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
use App\Services\Office\PropertyService as OfficePropertyService;
use App\Services\PropGeniusService;

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
    protected $propGeniusService;

    protected $falLicenseService;
    protected $PropertyService;



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
        EmployeeService $EmployeeService,
        PropGeniusService $propGeniusService,
        FalLicenseService $falLicenseService,
        OfficePropertyService $PropertyService
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
        $this->propGeniusService = $propGeniusService;
        $this->falLicenseService = $falLicenseService;
        $this->PropertyService = $PropertyService;



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

        // $falLicense = FalLicenseUser::where('user_id', auth()->id())
        // ->whereHas('falData', function ($query) {
        //     $query->where('for_gallery', 1);

        // })
        // ->where('ad_license_status', 'valid')
        // ->first();
        $falLicense = $this->falLicenseService->getValidLicenseForGallery();

        $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;
        $sectionsIds = auth()->user()
        ->UserOfficeData->UserSubscription->SubscriptionSectionData->pluck('section_id')
        ->toArray();

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
        //   return $request;
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
        dd($Unit);
        $officeId = auth()->user()->UserOfficeData->id;
        $subscription = $this->subscriptionService->findSubscriptionByOfficeId($officeId);
        $unitInterests = collect();
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
        $contracts = Contract::where('unit_id',$id)->get();

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
        // $falLicense = FalLicenseUser::where('user_id', auth()->id())
        // ->whereHas('falData', function ($query) {
        //     $query->where('for_gallery', 1);

        // })
        // ->where('ad_license_status', 'valid')
        // ->first();
        $falLicense = $this->falLicenseService->getValidLicenseForGallery();

        $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;
        $sectionsIds = auth()->user()
        ->UserOfficeData->UserSubscription->SubscriptionSectionData->pluck('section_id')
        ->toArray();

        return view('Office.ProjectManagement.Project.Unit.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        //  return $request;

        $Unit = $this->UnitService->findById($id);
        $this->UnitService->update($id, $request->all());
        if ($Unit->property_id != null) {
            return redirect()->route('Office.Property.show', $Unit->property_id)->with('success', __('Update successfully'));
        }
        if ($Unit->property_id != null && $Unit->project_id != null) {
            return redirect()->route('Office.Project.show', $Unit->project_id)->with('success', __('Update successfully'));
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

        // $property = Property::findOrFail($propertyId);
        $property = $this->PropertyService->findById($propertyId);

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
        // $unit = Unit::find($id);
        $unit = $this->UnitService->findById($id);

        if ($unit && $unit->video) {
            $unit->video = null;
            $unit->save();
            return response()->json(['success' => 'Video deleted']);
        }
        return response()->json(['error' => 'Video not found'], 404);
    }

    function IndexByStatus($type)
    {
        $units = $this->UnitService->getAll(auth()->user()->UserOfficeData->id);

        $projects = $units->pluck('ProjectData')->filter()->unique();
        $properties = $units->pluck('PropertyData')->filter()->unique();
        $propertyTypes = $units->pluck('PropertyTypeData')->filter()->unique();
        $usages = $units->pluck('PropertyUsageData')->filter()->unique();
        $statuses = $units->pluck('status')->unique()->filter();
        $units = $units->where('status', $type);

        return view('Office.ProjectManagement.Project.Unit.index', get_defined_vars());
    }

    function IndexByUsage($usage)
    {
        $units = $this->UnitService->getAll(auth()->user()->UserOfficeData->id);
        if ($usage == '5') {
            $units = $units->where('property_usage_id', '!=', $usage);
        } else {

            $units = $units->where('property_usage_id', $usage);
        }

        $projects = $units->pluck('ProjectData')->filter()->unique();
        $properties = $units->pluck('PropertyData')->filter()->unique();
        $propertyTypes = $units->pluck('PropertyTypeData')->filter()->unique();
        $usages = $units->pluck('PropertyUsageData')->filter()->unique();
        $statuses = $units->pluck('status')->unique()->filter();

        $usage = PropertyUsage::find($usage);
        return view('Office.ProjectManagement.Project.Unit.index', get_defined_vars());
    }

///////////////////////////////////////////////
//     public function generateDescription(Request $request)
//     {
//         $propertyDetails = $request->all();
//         // $propertyDetails = [
//         //     "type" => "client",
//         //     "property_id" => "123",
//         //     "productId" => "1",
//         //     "productType" => "property-description",
//         //     "language" => "English",
//         //     "attributes" => [
//         //         "advertisement_type" => "Sale",
//         //         "property_usage" => "Residential",
//         //         "property_type" => "Apartment",
//         //         "project_name" => "project test",
//         //         "country" => "India",
//         //         "city" => "gurugram",
//         //         "facing" => "East",
//         //         "built_up_area" => 10545,
//         //         "area_unit" => "SQM",
//         //         "num_bedrooms" => 3,
//         //         "amenities" => "Gym, swimming pool",
//         //         "price" => 544544,
//         //         "currency" => "INR",
//         //         "target_country" => "India",
//         //         "other_details" => "Testing description",
//         //         "num_words" => 200,
//         //         "address" => "Sector 49",
//         //         "landmark" => "near dlf mall",
//         //         "locality" => "DLF",
//         //         "street_name" => "Street 1",
//         //         "street_width" => 20,
//         //         "num_bathrooms" => 2,
//         //         "num_living_rooms" => 1,
//         //         "num_guest_rooms" => 1,
//         //         "property_floor_number" => "3",
//         //         "total_floors" => 4,
//         //         "fixtures_and_fittings" => "Jaguar Sanitation",
//         //         "num_parking" => 1,
//         //         "utilities" => ["Electricity"],
//         //         "property_age" => 1,
//         //         "furnishing" => "Semi-furnished",
//         //         "studio_apartment" => false
//         //     ]
//         // ];
//         $unit = Unit::findOrFail(305);
// // dd($unit->UnitServicesData);
//         if (!$unit) {
//             return response()->json(['error' => 'Unit not found'], 404);
//         }

//          $propertyDetails = [
//                 "type" => "client",
//                 "property_id" => "$unit->id",
//                 "productId" => "1",
//                 "productType" => "property-description",
//                 "language" => "Arabic",
//                 "attributes" => [
//                     "advertisement_type" => $unit->type,
//                     "property_usage" => $unit->PropertyUsageData->name,
//                     "property_type" => $unit->PropertyTypeData->name,
//                     "project_name" => $unit->ad_name,
//                     "country" => "Saudi Arabia",
//                     "city" => $unit->CityData->name,
//                     "facing" => "East",
//                     "built_up_area" => 10545,
//                     "area_unit" => "SQM",
//                     "num_bedrooms" => $unit->rooms,
//                     "amenities" => "$unit->UnitServicesData",
//                     "price" => $unit->price,
//                     "currency" => "INR",
//                     "target_country" => "Saudi Arabia",
//                     "other_details" => "Testing description",
//                     "num_words" => 300,
//                     "address" => "Sector 49",
//                     "landmark" => "near dlf mall",
//                     "locality" => "DLF",
//                     "street_name" => "Street 1",
//                     "street_width" => 20,
//                     "num_bathrooms" => $unit->bathrooms,
//                     "num_living_rooms" => 1,
//                     "num_guest_rooms" => 1,
//                     "property_floor_number" => "3",
//                     "total_floors" => 4,
//                     "fixtures_and_fittings" => "Jaguar Sanitation",
//                     "num_parking" => 1,
//                     "utilities" => ["Electricity"],
//                     "property_age" => 1,
//                     "furnishing" => "Semi-furnished",
//                     "studio_apartment" => false
//                 ]
//             ];
//             // dd($propertyDetails);
//         $description = $this->propGeniusService->generateDescription($propertyDetails);
//         return response()->json($description);
//     }

    public function showForm()
    {
        return view('property');
    }
    public function generateDescription(Request $request)
    {
        // Collect data from the request
        $propertyDetails = [
            "type" => "client",
            "property_id" => $request->input('property_id'),
            "productId" => "1",
            "productType" => "property-description",
            "language" => "Arabic",
            "attributes" => [
                "advertisement_type" => $request->input('advertisement_type'),
                "property_usage" => $request->input('property_usage'),
                "property_type" => $request->input('property_type'),
                "project_name" => $request->input('project_name'),
                "country" => "Saudi Arabia",
                "city" => $request->input('city'),
                "facing" => "East",
                "built_up_area" => $request->input('built_up_area'),
                "area_unit" => "SQM",
                "num_bedrooms" => $request->input('num_bedrooms'),
                "amenities" => $request->input('amenities'),
                "price" => $request->input('price'),
                "currency" => "INR",
                "target_country" => "Saudi Arabia",
                "other_details" => $request->input('other_details'),
                "num_words" => 300,
                "address" => $request->input('address'),
                "landmark" => "near dlf mall",
                "locality" => $request->input('locality'),
                "street_name" => "Street 1",
                "street_width" => 20,
                "num_bathrooms" => $request->input('num_bathrooms'),
                "num_living_rooms" => 1,
                "num_guest_rooms" => 1,
                "property_floor_number" => "3",
                "total_floors" => 4,
                "fixtures_and_fittings" => "Jaguar Sanitation",
                "num_parking" => 1,
                "utilities" => ["Electricity"],
                "property_age" => 1,
                "furnishing" => "Semi-furnished",
                "studio_apartment" => false
            ]
        ];

        $description = $this->propGeniusService->generateDescription($propertyDetails);

        return response()->json($description);
    }

}