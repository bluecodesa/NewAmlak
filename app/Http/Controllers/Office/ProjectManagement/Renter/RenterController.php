<?php

namespace App\Http\Controllers\Office\ProjectManagement\Renter;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\Office;
use App\Models\OfficeRenter;
use App\Models\Renter;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\RenterService;
use App\Services\RegionService;
use App\Models\User;
use App\Services\Office\ContractService;


use Illuminate\Validation\ValidationException;

class RenterController extends Controller
{

    protected $RenterService;
    protected $regionService;
    protected $cityService;
    protected $ContractService;


    public function __construct(RenterService $RenterService, RegionService $regionService,
    CityService $cityService,
    ContractService $ContractService
    )
    {
        $this->RenterService = $RenterService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->ContractService = $ContractService;

    }

    public function index()
    {
        $officeId = auth()->user()->UserOfficeData->id;
        $Renters = $this->RenterService->getAllByOfficeId($officeId);
        return view('Office.ProjectManagement.Renter.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */



// RenterController.php
    public function searchByIdNumber(Request $request)
    {
        $validatedData = $request->validate([
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
        ], [
            'id_number.required' => 'The ID number field is required.',
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
        ]);

        $idNumber = $validatedData['id_number'];
        $officeId = auth()->user()->UserOfficeData->id;

        $user = User::where('id_number', $idNumber)->first();

        if ($user) {

            if ($user->is_renter) {
                $existingRenter = Renter::where('user_id', $user->id)
                    ->whereHas('OfficeData', function ($query) use ($officeId) {
                        $query->where('office_id', $officeId);
                    })
                    ->first();
                    if ($existingRenter) {
                        return response()->json(['html' => view('Office.ProjectManagement.Renter.inc._result_renter', ['message' => __('User is already a renter in this office.'), 'user' => $user])->render()]);
                    }
                return response()->json(['html' => view('Office.ProjectManagement.Renter.inc.search-result-modal', ['message' => __('User found and is a property finder.'), 'user' => $user])->render()]);
            }
            if ($user->is_property_finder) {
                $existingRenter = Renter::where('user_id', $user->id)
                    ->whereHas('OfficeData', function ($query) use ($officeId) {
                        $query->where('office_id', $officeId);
                    })
                    ->first();

                if ($existingRenter) {
                    return response()->json(['html' => view('Office.ProjectManagement.Renter.inc._result_renter', ['message' => __('User found and is a property finder.'), 'user' => $user])->render()]);
                }

                return response()->json(['html' => view('Office.ProjectManagement.Renter.inc.search-result-modal', ['message' => __('User found and is a property finder.'), 'user' => $user])->render()]);
            }  if ($user) {
                return response()->json(['html' => view('Office.ProjectManagement.Renter.inc.search-result-modal', ['message' => __('User is already registered'), 'user' => $user])->render()]);
            }
            else {
                return response()->json(['html' => view('Office.ProjectManagement.Renter.inc._addRenter', ['message' => __('User is not registered'),session(['id_number' => $idNumber]),])->render()]);
            }
        } else {
            return response()->json(['html' => view('Office.ProjectManagement.Renter.inc._addRenter', ['message' => __('User is not registered'),session(['id_number' => $idNumber]),])->render()]);
        }
    }

public function addAsRenter($id)
{
    $officeId = auth()->user()->UserOfficeData->id;
    $user = User::find($id);

    if ($user) {
        $user->update(['is_renter' => 1]);
        $role = Role::firstOrCreate(['name' => 'Renter']);
        $user->assignRole($role);
        session(['active_role' => 'Renter']);
        $renter = Renter::updateOrCreate(['user_id' => $user->id]);
        $renter->OfficeData()->attach($officeId);

        return redirect()->route('Office.Renter.index')->with('success', 'User has been added as a renter to your office.');
    } else {
        return redirect()->route('Office.Renter.index')->with('error', 'User not found.');
    }
}


    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Renter.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->RenterService->createRenter($request->all());
        session(['active_role' => 'Renter']);
        return redirect()->route('Office.Renter.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $renter =  $this->RenterService->getRenterById($id);
        $officeRenters = $renter->OfficeRenterData;
        // $contracts =null;
        $contracts = $this->ContractService->getContractByRenterId($id);

        $installmentsPerRenter = $renter->installments;


        if ($officeRenters->isNotEmpty()) {
            foreach ($officeRenters as $officeRenter) {
                $renterStatus = $officeRenter->renter_status;
            }
                $Regions = $this->regionService->getAllRegions();
                $cities = $this->cityService->getAllCities();
                return view('Office.ProjectManagement.Renter.show', get_defined_vars());
            }
}

    public function edit($id)
    {
        $Renter =  $this->RenterService->getRenterById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.ProjectManagement.Renter.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->RenterService->updateRenter($id, $request->all());
        return redirect()->route('Office.Renter.index')->with('success', __('Update successfully'));
    }

    // public function destroy(string $id)
    // {
    //     $this->RenterService->deleteRenter($id);
    //     return redirect()->route('Office.Renter.index')->with('success', __('Deleted successfully'));
    // }
    public function destroy(string $id)
    {
        $renter = $this->RenterService->getRenterById($id);
        $UserId = auth()->user()->id;
        $officeId = auth()->user()->UserOfficeData->id;

        if ($renter->user_id === $UserId) {
            OfficeRenter::where('renter_id', $renter->id)
                ->where('office_id', $officeId)
                ->delete();

            return redirect()->route('Office.Owner.index')->with('success', __('You have been removed as an owner from your Office account.'));
        }

        $ownerInOtherAccounts = OfficeRenter::where('renter_id', $renter->id)
            ->where('office_id', '!=', $officeId)
            ->exists();

        if ($ownerInOtherAccounts) {
            OfficeRenter::where('owner_id', $renter->id)
                ->where('office_id', $officeId)
                ->delete();

            return redirect()->route('Office.Renter.index')->with('success', __('renter removed from your Office account.'));
        }

        OfficeRenter::where('renter_id', $renter->id)
        ->where('office_id', $officeId)
        ->delete();
        // $this->ownerService->deleteOwner($id);
        return redirect()->route('Office.Renter.index')->with('success', __('Deleted successfully'));
    }
}
