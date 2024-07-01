<?php

namespace App\Http\Controllers\Office\ProjectManagement\Receipt;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\OwnerService;
use App\Services\RegionService;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{

    protected $OwnerService;
    protected $regionService;
    protected $cityService;

    public function __construct(OwnerService $OwnerService, RegionService $regionService, CityService $cityService)
    {
        $this->OwnerService = $OwnerService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $owners = $this->OwnerService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.ProjectManagement.Owner.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Owner.create', get_defined_vars());
    }

    // public function store(Request $request)
    // {
    //     $this->OwnerService->createOwner($request->all());
    //     return redirect()->route('Office.Owner.index')->with('success', __('added successfully'));
    // }

    public function store(Request $request)
    {
    $validatedData = $request->validate([
            'voucher_number' => 'required|string|unique:receipts,voucher_number',
            'release_date' => 'required|date',
            'payment_date' => 'required|date',
            'contract_id' => 'required|exists:contracts,id',
            'payment_method' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'installments' => 'required|array',
            'installments.*' => 'numeric|min:0'
        ]);
            $installmentIds = $validatedData['installments'];

            $installmentNumbers = Installment::whereIn('id', $installmentIds)->pluck('installment_number')->toArray();


        // Create the receipt
        $receipt = Receipt::create([
            'voucher_number' => $request->voucher_number,
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
            'reference_number' => $request->reference_number,
            'transaction_number' => $request->transaction_number,
        ]);

        $receipt->installments()->attach($validatedData['installments']);

        $voucherNumber = $receipt->id . '-' . implode('-', $installmentNumbers);

        $receipt->update(['voucher_number' => $voucherNumber]);

        return redirect()->back()->with('success', 'Receipt created successfully.');

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
}
