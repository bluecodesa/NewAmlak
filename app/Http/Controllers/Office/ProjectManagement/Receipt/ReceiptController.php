<?php

namespace App\Http\Controllers\Office\ProjectManagement\Receipt;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attachment;
use App\Models\AttachmentContract;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\Project;
use App\Models\Property;
use App\Models\Setting;
use App\Models\Unit;
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
use PDF;
use Illuminate\Validation\Rule;

class ReceiptController extends Controller
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
        //
        $officeId=auth()->user()->UserOfficeData->id;
        $receipts = Receipt::all()->where('office_id',$officeId);
        $setting =   Setting::first();
        return view('Office.FinancialManagment.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        // 'voucher_number' => 'required|string|unique:receipts,voucher_number',
        'release_date' => 'required|date',
        'payment_date' => 'required|date',
        // 'contract_id' => 'required|exists:contracts,id',
        'payment_method' => 'required|string',
        'total_price' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
        'installments' => 'required|array',
        'installments.*' => 'numeric|min:0'
    ], [
        // 'voucher_number.required' => 'The voucher number is required.',
        'voucher_number.string' => 'The voucher number must be a string.',
        'voucher_number.unique' => 'The voucher number has already been taken.',
        'release_date.required' => 'The release date is required.',
        'release_date.date' => 'The release date is not a valid date.',
        'payment_date.required' => 'The payment date is required.',
        'payment_date.date' => 'The payment date is not a valid date.',
        'contract_id.required' => 'The contract ID is required.',
        'contract_id.exists' => 'The selected contract ID is invalid.',
        'payment_method.required' => 'The payment method is required.',
        'payment_method.string' => 'The payment method must be a string.',
        'total_price.required' => 'The total price is required.',
        'total_price.numeric' => 'The total price must be a number.',
        'total_price.min' => 'The total price must be at least 0.',
        'notes.string' => 'The notes must be a string.',
        'installments.required' => 'The installments are required.',
        'installments.array' => 'The installments must be an array.',
        'installments.*.numeric' => 'Each installment must be a number.',
        'installments.*.min' => 'Each installment must be at least 0.'
    ]);
        $installmentIds = $validatedData['installments'];

        $installmentNumbers = Installment::whereIn('id', $installmentIds)->pluck('installment_number')->toArray();
        $Contract_id = $request->contract_id;

            $contract = Contract::find($Contract_id);

            if ($contract) {
                $contractNumber = $contract->contract_number;
            }

    // Create the receipt
    $receipt = Receipt::create([
        'voucher_number' => $request->voucher_number ?? null,
        'release_date' => $request->release_date,
        'payment_date' => $request->payment_date,
        'office_id' => Auth::user()->UserOfficeData->id,
        'contract_id' => $request->contract_id,
        'project_id' => $request->project_id,
        'property_id' => $request->property_id,
        'unit_id' => $request->unit_id,
        'renter_id' => $request->renter_id,
        'payment_method' => $request->payment_method,
        'total_price' => $request->total_price,
        'notes' => $request->notes,
        'mobile' => $request->mobile,
        'type' => 'receipt_voucher',
        'reference_number' => $request->reference_number,
        'transaction_number' => $request->transaction_number,
    ]);

    $installmentNumbers = Installment::whereIn('id', $validatedData['installments'])->pluck('installment_number')->toArray();
    $voucherNumber = $contractNumber . '-' . $receipt->id;
    $receipt->update(['voucher_number' => $voucherNumber]);

    foreach ($validatedData['installments'] as $installmentId) {
        $receipt->installments()->attach($installmentId);

        $installment = Installment::find($installmentId);
        if ($installment) {
            $installment->update(['status' => 'collected']);
        }
    }
    return redirect()->back()->with('success', 'Receipt created successfully.');

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receipt = Receipt::with('installments')->findOrFail($id);
        return response()->json($receipt);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


public function download($id)
{
    $receipt = Receipt::with('installments', 'contract', 'contract.property', 'contract.unit', 'contract.renter')->findOrFail($id);
    $pdf = PDF::loadView('receipt_pdf', compact('receipt'));
    return $pdf->download('receipt_' . $receipt->voucher_number . '.pdf');
}

}
