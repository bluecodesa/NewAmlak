<?php


namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\FalLicenseUser;
use App\Models\PropertyImage;
use App\Services\Admin\FalLicenseService;
use App\Services\AllServiceService;
use App\Services\CityService;
use App\Services\Office\OfficeDataService;
use App\Services\Office\PropertyService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Office\EmployeeService;


class PropertyController extends Controller
{
    protected $PropertyService;
    protected $regionService;
    protected $cityService;
    protected $officeDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;
    protected $EmployeeService;
    protected $falLicenseService;

    public function __construct(PropertyService $PropertyService, AllServiceService $AllServiceService, FeatureService $FeatureService, RegionService $regionService, CityService $cityService, OfficeDataService $officeDataService, PropertyTypeService $propertyTypeService,
    ServiceTypeService $ServiceTypeService,
    PropertyUsageService $propertyUsageService,
    EmployeeService $EmployeeService,
    FalLicenseService $falLicenseService
    )
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->PropertyService = $PropertyService;
        $this->officeDataService = $officeDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;
        $this->EmployeeService = $EmployeeService;
        $this->falLicenseService = $falLicenseService;


        $this->middleware(['role_or_permission:read-building'])->only(['index']);
        $this->middleware(['role_or_permission:create-building'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-building'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-building'])->only(['destroy']);
        $this->middleware(['role_or_permission:create-unit'])->only(['CreateUnit']);
    }

    public function index()
    {
        $properties = $this->PropertyService->getAll(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Project.Property.index',  get_defined_vars());
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
        $services = $this->ServiceTypeService->getAllServiceTypes();
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

        return view('Office.ProjectManagement.Project.Property.create', get_defined_vars());
    }

    public function store(Request $request)
    {

        // $rules = [];
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'service_type_id' => 'required|exists:service_types,id',
        //     // 'is_divided' => 'required|boolean',
        //     'city_id' => 'required|exists:cities,id',
        //     'owner_id' => 'required|exists:owners,id',
        //     'instrument_number' => [
        //         'nullable',
        //         Rule::unique('properties'),
        //         'max:25'
        //     ],
        // ];
        // $messages = [
        //     'instrument_number.unique' => 'The instrument number has already been taken.',
        // ];
        // $request->validate($rules, $messages);

        $images = $request->file('images');
        $this->PropertyService->store($request->except('images'), $images);
        return redirect()->route('Office.Property.index')->with('success', __('added successfully'));
    }

    public function show($id)
    {
        $Property = $this->PropertyService->findById($id);
        $contracts = Contract::where('property_id',$id)->get();

        return view('Office.ProjectManagement.Project.Property.show',  get_defined_vars());
    }

    public function edit($id)
    {
        $Property = $this->PropertyService->findById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $advisors = $this->officeDataService->getAdvisors();
        $developers = $this->officeDataService->getDevelopers();
        $owners = $this->officeDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
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

        return view('Office.ProjectManagement.Project.Property.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $rules = [];
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'service_type_id' => 'required|exists:service_types,id',
            // 'is_divided' => 'required|boolean',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'instrument_number' => [
                'nullable',
                Rule::unique('properties')->ignore($id),
                'max:25'
            ],
        ];
        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than :max characters.',
            'service_type_id.required' => 'The service type ID field is required.',
            'service_type_id.exists' => 'The selected service type ID is invalid.',
            'city_id.required' => 'The city ID field is required.',
            'city_id.exists' => 'The selected city ID is invalid.',
            'owner_id.required' => 'The owner ID field is required.',
            'owner_id.exists' => 'The selected owner ID is invalid.',
            'instrument_number.unique' => 'The instrument number has already been taken.',
            'instrument_number.max' => 'The instrument number may not be greater than :max characters.',
        ];

        $request->validate($rules, $messages);

        $images = $request->images;
        $this->PropertyService->update($id, $request->except('images'), $images);
        $Property = $this->PropertyService->findById($id);
        if ($Property->project_id != null) {
            return redirect()->route('Office.Project.show', $Property->project_id)->with('success', __('Update successfully'));
        } else {
            return redirect()->route('Office.Property.index')->with('success', __('Update successfully'));
        }
    }

    public function destroy(string $id)
    {
        $this->PropertyService->delete($id);
        return redirect()->route('Office.Property.index')->with('success', __('Deleted successfully'));
    }

    //

    function CreateUnit($id)
    {
        $Property = $this->PropertyService->findById($id);
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

        return view('Office.ProjectManagement.Project.Property.CreateUnit', get_defined_vars());
    }

    public function autocomplete(Request $request)
    {
        $data = $this->PropertyService->autocomplete($request->all());
        return response()->json($data);
    }

    function StoreUnit(Request $request, $id)
    {
        $this->PropertyService->StoreUnit($id, $request->all());
        return redirect()->route('Office.Property.show', $id)->with('success', __('added successfully'));
    }


    function deleteImage($id)
    {
        $Property = $this->PropertyService->findById($id);
        $Property->PropertyImages()->delete();
        PropertyImage::create([
            'image' => 'Offices/Projects/default.svg',
            'property_id' => $id,
        ]);
    }
}