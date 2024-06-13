<?php

namespace App\Http\Controllers\Office\ProjectManagement\Renter;

use App\Http\Controllers\Controller;
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
        $Renters = $this->RenterService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
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

    // Search for the user by id_number
    $user = User::where('id_number', $idNumber)->first();

    if ($user) {
        // If user found, check if they are already a renter
        if ($user->is_property_finder) {
            session(['found_user' => $user]);
            return redirect()->route('Office.Renter.add', ['id' => $user->id])->with('success', 'User is already registered before And now he is as a renter.');
            // return redirect()->back()->with('success', 'User is already registered before.');
        }
        // else {
        //     // Set a session variable or data to indicate found user
        //     session(['found_user' => $user]);
        //     return redirect()->route('Office.Renter.add', ['id' => $user->id]);
        // }
    } else {
        return redirect()->route('Office.Renter.create')->with('success' ,'رقم الهوية لم يكن مسجل من قبل .. اكمل البيانات لتكملة التسجيل.');
    }
}

public function add($id)
{
    // Validate if user with $id exists
    $user = User::findOrFail($id);
    // If user is not already a renter, mark them as a renter
    if (!$user->is_renter) {
        $user->update(['is_renter' => 1]);
        Renter::create([
            'user_id' => $user->id,
            'office_id' => auth()->user()->UserOfficeData->id,
        ]);
        return redirect()->route('Office.Renter.index')->with('success', 'User  is already registered before  And now  added as renter successfully.');
    }

    return redirect()->back()->with('error', 'User is already registered as a renter.');
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
