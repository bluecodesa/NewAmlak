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

    public function store(Request $request)
    {
        $this->ContractService->createContract($request->all());
        return redirect()->route('Office.Contract.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        return view('Office.Contract.show', get_defined_vars());


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
        $units = $property->PropertyUnits;
        return response()->json([
            'units' => $units
        ]);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'property_id' => 'nullable|exists:properties,id',
            'unit_id' => 'required|exists:units,id',
            'owner_id' => 'required|exists:owners,id',
            'employee_id' => 'nullable|exists:employees,id',
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
        ]);

        if (is_null($validatedData['employee_id'])) {
            $validatedData['employee_id'] = Auth::id();
        }

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
        $contract = Contract::find($id);

        $contract->update($contractData);

        // Handle attachments
        if ($request->has('attachment')) {
            // Delete existing attachments
            $contract->ContractAttachmentData()->delete();

            // Upload new attachments
            foreach ($request->file('attachment') as $index => $attachmentFile) {
                $attachmentName = $validatedData['name'][$index] ?? 'Attachment ' . ($index + 1);

                $filePath = $attachmentFile->store('attachments');

                $attachment = Attachment::create([
                    'name' => $attachmentName,
                    'created_by' => Auth::id(),
                ]);

                ContractAttachment::create([
                    'attachment_id' => $attachment->id,
                    'contract_id' => $contract->id,
                    'attachment' => $filePath,
                ]);
            }
        }
        $this->updateInstallments($contract, $validatedData);

        return redirect()->route('Office.Contract.index')->with('success', 'Contract updated successfully.');
    }

    private function updateInstallments(Contract $contract, array $data)
    {
        // Delete existing installments
        $contract->installments()->delete();

        // Create new installments
        $numberOfContracts = 1;
        $installments = [];

        if ($data['duration_unit'] === 'year' && $data['payment_cycle'] === 'annual') {
            $numberOfContracts = $data['contract_duration'];
        } else if ($data['duration_unit'] === 'month' && $data['payment_cycle'] === 'monthly') {
            $numberOfContracts = $data['contract_duration'];
        } else if ($data['duration_unit'] === 'year' && $data['payment_cycle'] === 'monthly') {
            $numberOfContracts = $data['contract_duration'] * 12;
        }

        // Determine start date
        if ($data['gregorian_contract_date']) {
            $startDate = new \DateTime($data['gregorian_contract_date']);
        } elseif ($data['hijri_contract_date']) {
            $startDate = new \DateTime($data['hijri_contract_date']);
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

    public function certify(Contract $contract)
{
    $contract->update(['status' => 'Certified']);
    return response()->json(['success' => true]);
}

public function deportation(Contract $contract)
{
    $contract->update(['status' => 'Relay']);
    return response()->json(['success' => true]);
}


public function reset(Contract $contract)
{
    try {
        $contract->delete();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

public function updateValidity(Request $request)
    {
        $contracts = Contract::where('status', 'Relay')
            ->where('start_contract_date', '<', Carbon::now())
            ->where('contract_validity', '!=', 'active')
            ->get();

        foreach ($contracts as $contract) {
            $contract->contract_validity = 'active';
            $contract->unit->status = 'rented';
            $contract->save();
        }

        return response()->json(['success' => true, 'message' => 'Contract validity updated successfully.']);
    }

    // public function updateValidity(Request $request)
    // {
    //     $contracts = Contract::where('status', 'Relay')
    //         ->where('contract_validity', '!=', 'active')
    //         ->get();

    //     foreach ($contracts as $contract) {
    //         if ($contract->calendarTypeSelect === 'gregorian') {
    //             $startContractDate = Carbon::parse($contract->start_contract_date);
    //         } elseif ($contract->calendarTypeSelect === 'hijri') {
    //             $hijriDate = Hijri::convertToGregorian($contract->start_contract_date);
    //             $startContractDate = Carbon::createFromDate($hijriDate->year, $hijriDate->month, $hijriDate->day);
    //         } else {
    //             continue;
    //         }

    //         if ($startContractDate->lessThan(Carbon::now())) {
    //             $contract->contract_validity = 'active';
    //             $contract->save();
    //         }
    //     }

    //     return response()->json(['success' => true, 'message' => 'Contract validity updated successfully.']);
    // }

    public function getUnitDetails($unitId)
{
    $unit = Unit::findOrFail($unitId);

    // Load related data
    $unit->load('OwnerData', 'UnitRentPrice');

    // Prepare response data
    $responseData = [
        'owner_id' => $unit->owner_id,
        'unit_rental_price' => $unit->UnitRentPrice,
    ];

    return response()->json($responseData);
}


}
