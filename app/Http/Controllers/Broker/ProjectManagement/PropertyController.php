<?php


namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\TicketType;
use App\Services\AllServiceService;
use App\Services\CityService;
use App\Services\Broker\BrokerDataService;
use App\Services\Broker\PropertyService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    protected $PropertyService;
    protected $regionService;
    protected $cityService;
    protected $brokerDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;
    public function __construct(PropertyService $PropertyService, AllServiceService $AllServiceService, FeatureService $FeatureService, RegionService $regionService, CityService $cityService, BrokerDataService $brokerDataService, PropertyTypeService $propertyTypeService, ServiceTypeService $ServiceTypeService, PropertyUsageService $propertyUsageService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->PropertyService = $PropertyService;
        $this->brokerDataService = $brokerDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;

        $this->middleware(['role_or_permission:read-building'])->only(['index','show']);
        $this->middleware(['role_or_permission:create-building'])->only(['create', 'store']);
        $this->middleware(['role_or_permission:update-building'])->only(['edit', 'update']);
        $this->middleware(['role_or_permission:delete-building'])->only(['destroy']);
        $this->middleware(['role_or_permission:create-unit'])->only(['CreateUnit']);
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
                Rule::unique('properties'),
                'max:25'
            ],
        ];
        $messages = [
            'instrument_number.unique' => 'The instrument number has already been taken.',
        ];
        $request->validate($rules, $messages);

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
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        return view('Broker.ProjectManagement.Project.Property.edit', get_defined_vars());
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
            return redirect()->route('Broker.Project.show', $Property->project_id)->with('success', __('Update successfully'));
        } else {
            return redirect()->route('Broker.Property.index')->with('success', __('Update successfully'));
        }
    }

    public function destroy(string $id)
    {
        $this->PropertyService->delete($id);
        return redirect()->route('Broker.Property.index')->with('success', __('Deleted successfully'));
    }

    //

    function CreateUnit($id)
    {
        $Property = $this->PropertyService->findById($id);
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
        return view('Broker.ProjectManagement.Project.Property.CreateUnit', get_defined_vars());
    }

    public function autocomplete(Request $request)
    {
        $data = $this->PropertyService->autocomplete($request->all());
        return response()->json($data);
    }

    function StoreUnit(Request $request, $id)
    {
        $this->PropertyService->StoreUnit($id, $request->all());
        return redirect()->route('Broker.Property.show', $id)->with('success', __('added successfully'));
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

    public function showPubllicProperty($gallery_name, $id)
    {
        $property = $this->PropertyService->ShowPublicProject($id);

        if(!empty($property) && $property->BrokerData->license_validity == 'valid' && $property->BrokerData->GalleryData->gallery_status != 0 ){
            $ticketTypes =  TicketType::paginate(100);
            return view('Home.Gallery.Property.show',  get_defined_vars());
        }
        else {
            $property = Property::findOrFail($id);
            $broker=$property->BrokerData;
            return view('Broker.Gallary.inc._GalleryComingsoon', get_defined_vars());
        }
    }

}
