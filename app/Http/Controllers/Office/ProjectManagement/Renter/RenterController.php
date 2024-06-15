<?php

namespace App\Http\Controllers\Office\ProjectManagement\Renter;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Renter;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\RenterService;
use App\Services\RegionService;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RenterController extends Controller
{

    protected $RenterService;
    protected $regionService;
    protected $cityService;

    public function __construct(RenterService $RenterService, RegionService $regionService, CityService $cityService)
    {
        $this->RenterService = $RenterService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
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



     public function searchByIdNumber(Request $request)
     {
         $validatedData = $request->validate([
             'id_number' => 'required|string',
         ]);

         $idNumber = $validatedData['id_number'];
         $officeId = auth()->user()->UserOfficeData->id;

         $user = User::where('id_number', $idNumber)->first();

         if ($user) {
             if ($user->is_property_finder) {
                 // Check if the user is already a renter in this office
                 $existingRenter = Renter::where('user_id', $user->id)
                     ->whereHas('OfficeData', function ($query) use ($officeId) {
                         $query->where('office_id', $officeId);
                     })
                     ->first();

                 if ($existingRenter) {
                     return redirect()->route('Office.Renter.index')
                         ->with('error', 'User is already a renter in this office.');
                 }

                 // Update user as renter and associate with office
                 $user->update(['is_renter' => 1]);
                 $renter = Renter::updateOrCreate(['user_id' => $user->id]);
                 $renter->OfficeData()->attach($officeId);

                 return redirect()->route('Office.Renter.index')
                     ->with('success', 'User is already registered as a property finder and has been added as a renter to your office.');
             } else {
                 // Check if the user is already a renter in this office
                 $existingRenter = Renter::where('user_id', $user->id)
                     ->whereHas('OfficeData', function ($query) use ($officeId) {
                         $query->where('office_id', $officeId);
                     })
                     ->first();

                 if ($existingRenter) {
                     return redirect()->route('Office.Renter.index')
                         ->with('error', 'User is already a renter in this office.');
                 }

                 // Add the user as a renter for the current office
                 $renter = Renter::updateOrCreate(['user_id' => $user->id]);
                 $renter->offices()->attach($officeId);

                 return redirect()->route('Office.Renter.index')
                     ->with('success', 'User has been added as a renter to your office.');
             }
         } else {
             return redirect()->route('Office.Renter.create')
                 ->with('success', 'رقم الهوية لم يكن مسجل من قبل .. اكمل البيانات لتكملة التسجيل.');
         }
     }

     public function addToOffice($userId)
     {
         $user = User::findOrFail($userId);

         // Check if the user is already a renter
         if (!$user->is_renter) {
             $user->update(['is_renter' => 1]);
             $renter = Renter::create(['user_id' => $userId]);
         } else {
             $renter = $user->UserRenterData()->first();
         }

         $officeId = auth()->user()->UserOfficeData->id;
         $office = Office::find($officeId);
         $office->RenterData()->attach($renter->id);

         return redirect()->route('Office.Renter.index')->with('success', __('Renter added to office successfully.'));
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
        return redirect()->route('Office.Renter.index')->with('success', __('added successfully'));
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

    public function destroy(string $id)
    {
        $this->RenterService->deleteRenter($id);
        return redirect()->route('Office.Renter.index')->with('success', __('Deleted successfully'));
    }
}
