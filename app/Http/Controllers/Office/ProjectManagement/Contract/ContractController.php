<?php

namespace App\Http\Controllers\Office\ProjectManagement\Contract;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\AttachmentContract;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\Installment;
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
use App\Services\Office\ContractService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\ServiceTypeService;
use App\Services\Office\EmployeeService;
use App\Services\Office\RenterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



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
    protected $ContractService;



    public function __construct(
        SettingService $settingService,
        ContractService $ContractService,
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
        $this->ContractService = $ContractService;
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
        $contracts = $this->ContractService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
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

    // public function store(Request $request)
    // {
    //     $this->OwnerService->createOwner($request->all());
    //     return redirect()->route('Office.Owner.index')->with('success', __('added successfully'));
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
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
        $contract =  $this->ContractService->getContractById($id);


        return view('Office.Contract.edit', get_defined_vars());
    }

    // public function update(Request $request, $id)
    // {
    //     $this->OwnerService->updateOwner($id, $request->all());
    //     return redirect()->route('Office.Owner.index')->with('success', __('Update successfully'));
    // }

    public function destroy(string $id)
    {
        $this->ContractService->deleteContract($id);
        return redirect()->route('Office.Contract.index')->with('success', __('Deleted successfully'));
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'property_id' => 'nullable|exists:properties,id',
            'unit_id' => 'required|exists:units,id',
            'owner_id' => 'required|exists:owners,id',
            'employee_id' => 'required|exists:employees,id',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'service_type_id' => 'required|exists:service_types,id',
            'commissions_rate' => 'nullable|numeric',
            'collection_type' => 'nullable|string',
            'renter_id' => 'required|exists:renters,id',
            'calendarTypeSelect' => 'required|string|in:gregorian,hijri',
            'gregorian_contract_date' => 'nullable|date',
            'hijri_contract_date' => 'nullable|string',
            'date_concluding_contract' => 'nullable|date',
            'contract_duration' => 'required|integer',
            'duration_unit' => 'required|string',
            'payment_cycle' => 'required|string',
            'auto_renew' => 'required|string',
            'name.*' => 'nullable|string',
            'attachment.*' => 'nullable|file',
        ], [
            'project_id.required' => 'The project ID field is required.',
            'project_id.exists' => 'The selected project ID is invalid.',
            'property_id.required' => 'The property ID field is required.',
            'property_id.exists' => 'The selected property ID is invalid.',
            'unit_id.required' => 'The unit ID field is required.',
            'unit_id.exists' => 'The selected unit ID is invalid.',
            'owner_id.required' => 'The owner ID field is required.',
            'owner_id.exists' => 'The selected owner ID is invalid.',
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.exists' => 'The selected employee ID is invalid.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'service_type_id.required' => 'The service type ID field is required.',
            'service_type_id.exists' => 'The selected service type ID is invalid.',
            'commissions_rate.numeric' => 'The commissions rate must be a number.',
            'collection_type.string' => 'The collection type must be a string.',
            'renter_id.required' => 'The renter ID field is required.',
            'renter_id.exists' => 'The selected renter ID is invalid.',
            'calendarTypeSelect.required' => 'The calendar type field is required.',
            'calendarTypeSelect.string' => 'The calendar type must be a string.',
            'calendarTypeSelect.in' => 'The calendar type must be either gregorian or hijri.',
            'gregorian_contract_date.date' => 'The Gregorian contract date must be a valid date.',
            'hijri_contract_date.string' => 'The Hijri contract date must be a valid string.',
            'date_concluding_contract.date' => 'The concluding contract date must be a valid date.',
            'contract_duration.required' => 'The contract duration field is required.',
            'contract_duration.integer' => 'The contract duration must be an integer.',
            'duration_unit.required' => 'The duration unit field is required.',
            'duration_unit.string' => 'The duration unit must be a string.',
            'payment_cycle.required' => 'The payment cycle field is required.',
            'payment_cycle.string' => 'The payment cycle must be a string.',
            'auto_renew.required' => 'The auto renew field is required.',
            'auto_renew.string' => 'The auto renew field must be a string.',
            'name.*.string' => 'The name field for attachments must be a string.',
            'attachment.*.file' => 'The attachment must be a file.',
        ]);
        

        $contractData = [
            'office_id' => auth()->user()->UserOfficeData->id,
            'project_id' => $validatedData['project_id'] ?? null,
            'property_id' => $validatedData['property_id'] ?? null,
            'unit_id' => $validatedData['unit_id'],
            'owner_id' => $validatedData['owner_id'],
            'employee_id' => $validatedData['employee_id'],
            'price' => $validatedData['price'],
            'type' => $validatedData['type'],
            'service_type_id' => $validatedData['service_type_id'],
            'commissions_rate' => $validatedData['commissions_rate'],
            'collection_type' => $validatedData['collection_type'] ?? null,
            'renter_id' => $validatedData['renter_id'],
            'contract_duration' => $validatedData['contract_duration'],
            'duration_unit' => $validatedData['duration_unit'],
            'payment_cycle' => $validatedData['payment_cycle'],
            'auto_renew' => $validatedData['auto_renew'],
            'date_concluding_contract' => $validatedData['date_concluding_contract'],
            'calendarTypeSelect' => $validatedData['calendarTypeSelect'],


        ];
        if ($validatedData['gregorian_contract_date']) {
            $startDate = Carbon::parse($validatedData['gregorian_contract_date']);
            $contractData['start_contract_date'] = $startDate;
        } elseif ($validatedData['hijri_contract_date']) {
            $startDate = Carbon::parse($validatedData['hijri_contract_date']);
            $contractData['start_contract_date'] = $startDate;
        }
        switch ($validatedData['duration_unit']) {
            case 'month':
                $endDate = $startDate->copy()->addMonths($validatedData['contract_duration']);
                break;
            case 'year':
                $endDate = $startDate->copy()->addYears($validatedData['contract_duration']);
                break;
            default:
                return back()->withErrors(['duration_unit' => 'Invalid duration unit provided.']);
        }
    
        $contractData['end_contract_date'] = $endDate;

        $contract = Contract::create($contractData);

        foreach ($request->file('attachment') as $index => $attachmentFile) {
            $attachmentName = $validatedData['name'][$index];
    
            $filePath = $attachmentFile->store('attachments');
    
            $attachment = Attachment::where('name', $attachmentName)->first();
    
            if (!$attachment) {
                $attachment = Attachment::create([
                    'name' => $attachmentName,
                    'created_by' => Auth::id(),
                ]);
            }
    
            ContractAttachment::create([
                'attachment_id' => $attachment->id,
                'contract_id' => $contract->id,
                'attachment' => $filePath, 
            ]);
        }
        $contractNumber = '100' . $contract->id;

        $contract->update(['contract_number' => $contractNumber]);

        $this->createInstallments($contract, $validatedData);

        return redirect()->route('Office.Contract.index')->with('success', 'Contract created successfully.');
    }

    private function createInstallments(Contract $contract, array $data)
    {
        $numberOfContracts = 1;
        $installments = [];

        if ($data['duration_unit'] === 'year' && $data['payment_cycle'] === 'annual') {
            $numberOfContracts = $data['contract_duration'];
        } else if ($data['duration_unit'] === 'month' && $data['payment_cycle'] === 'monthly') {
            $numberOfContracts = $data['contract_duration'];
        } else if ($data['duration_unit'] === 'year' && $data['payment_cycle'] === 'monthly') {
            $numberOfContracts = $data['contract_duration'] * 12;
        }

        // $startDate = new \DateTime($data['contract_date']);
        if ($data['gregorian_contract_date']) {
            $startDate = new \DateTime($data['gregorian_contract_date']);
        } elseif ($data['hijri_contract_date']) {
            $hijriDate = $data['hijri_contract_date'];
            $startDate = new \DateTime($hijriDate);
        } else {
            throw new \InvalidArgumentException('Invalid calendar type provided.');
        }
        $pricePerContract = $data['price'] / $numberOfContracts;
        $commissionPerContract = 0;

        if ($data['service_type_id'] == 3) {
            if ($data['collection_type'] == 'once') {
                $commissionPerContract = ($data['commissions_rate'] / 100) * $data['price'];
            } else if ($data['collection_type'] == 'divided') {
                $commissionPerContract = ($data['commissions_rate'] / 100) * ($data['price'] / $numberOfContracts);
            }
        }

        for ($i = 0; $i < $numberOfContracts; $i++) {
            $endDate = clone $startDate;
            if ($data['duration_unit'] === 'month') {
                $endDate->modify('+1 month');
            } else if ($data['duration_unit'] === 'year') {
                $endDate->modify('+1 year');
            }

            $finalPrice = $pricePerContract;
            if ($commissionPerContract !== 0) {
                if ($data['collection_type'] === 'once') {
                    if ($i === 0) {
                        $finalPrice += $commissionPerContract;
                    }
                } else if ($data['collection_type'] === 'divided') {
                    $finalPrice += $commissionPerContract;
                }
            }

            $installments[] = [
                'contract_id' => $contract->id,
                'price' => $finalPrice,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d')
            ];

            $startDate = clone $endDate;
        }

        Installment::insert($installments);
    }

    public function update(Request $request, Contract $contract)
{
    $validatedData = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'property_id' => 'required|exists:properties,id',
        'unit_id' => 'required|exists:units,id',
        'owner_id' => 'required|exists:owners,id',
        'employee_id' => 'required|exists:employees,id',
        'price' => 'required|numeric',
        'type' => 'required|string',
        'service_type_id' => 'required|exists:service_types,id',
        'commissions_rate' => 'nullable|numeric',
        'collection_type' => 'nullable|string',
        'renter_id' => 'required|exists:renters,id',
        'gregorian_contract_date' => 'nullable|date',
        'hijri_contract_date' => 'nullable|string',
        'date_concluding_contract' => 'nullable|date',
        'contract_duration' => 'required|integer',
        'duration_unit' => 'required|string',
        'payment_cycle' => 'required|string',
        'auto_renew' => 'required|string'
    ]);

    $contract->project_id = $validatedData['project_id'];
    $contract->property_id = $validatedData['property_id'];
    $contract->unit_id = $validatedData['unit_id'];
    $contract->owner_id = $validatedData['owner_id'];
    $contract->employee_id = $validatedData['employee_id'];
    $contract->price = $validatedData['price'];
    $contract->type = $validatedData['type'];
    $contract->service_type_id = $validatedData['service_type_id'];
    $contract->commissions_rate = $validatedData['commissions_rate'];
    $contract->collection_type = $validatedData['collection_type'] ?? null;
    $contract->renter_id = $validatedData['renter_id'];
    $contract->contract_duration = $validatedData['contract_duration'];
    $contract->duration_unit = $validatedData['duration_unit'];
    $contract->payment_cycle = $validatedData['payment_cycle'];
    $contract->auto_renew = $validatedData['auto_renew'];

    if ($validatedData['gregorian_contract_date']) {
        $contract->contract_date = $validatedData['gregorian_contract_date'];
    } elseif ($validatedData['hijri_contract_date']) {
        $contract->contract_date = $validatedData['hijri_contract_date'];
    }

    $contract->save();

    // Update installments logic
    $this->updateInstallments($contract, $validatedData);

    return redirect()->route('Office.Contract.index')->with('success', 'Contract updated successfully.');
}

private function updateInstallments(Contract $contract, array $data)
{

}

}