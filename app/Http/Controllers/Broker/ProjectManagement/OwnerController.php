<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Broker\OwnerService;
use App\Services\RegionService;

class OwnerController extends Controller
{

    protected $ownerService;
    protected $regionService;
    protected $cityService;

    public function __construct(OwnerService $ownerService, RegionService $regionService, CityService $cityService)
    {
        $this->ownerService = $ownerService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $owners = $this->ownerService->getAllByBrokerId(auth()->user()->UserBrokerData->id);
        return view('Broker.ProjectManagement.Owner.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Owner.create', get_defined_vars());
    }

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
        $brokerId = auth()->user()->UserBrokerData->id;

        $user = User::where('id_number', $idNumber)->first();
        if ($user) {
            if ($user->is_owner) {
                $existingOwner = Owner::where('user_id', $user->id)
                    ->whereHas('brokers', function ($query) use ($brokerId) {
                        $query->where('broker_id', $brokerId);
                    })
                    ->first();

                if ($existingOwner) {
                    return response()->json([
                        'html' => view('Broker.ProjectManagement.Owner.inc._result_renter', [
                            'message' => __('User is already an Owner in this Broker.'),
                            'user' => $user,
                        'id_number'=>$idNumber

                        ])->render()
                    ]);
                } else {
                    return response()->json([
                        'html' => view('Broker.ProjectManagement.Owner.inc.search-result-modal', [
                            'message' => __('User found and is a property finder.'),
                            'user' => $user,
                            'id_number'=>$idNumber
                        ])->render()
                    ]);
                }
            } else {
                return response()->json([
                    'html' => view('Broker.ProjectManagement.Owner.inc.search-result-modal', [
                        'message' => __('User found and is a property finder.'),
                        'user' => $user,
                        'id_number'=>$idNumber
                    ])->render()
                ]);
            }
        } else {
            return response()->json([
                'html' => view('Broker.ProjectManagement.Owner.inc._addRenter', [
                    'message' => __('User is not registered'),
                    session(['id_number' => $idNumber]),
                    ])->render()
            ]);
        }
    }

    public function addAsOwner(Request $request)
{
    // Validate the request data
    $request->validate([
        'id_number' => [
            'required',
            'string',
            'max:25',
            function ($attribute, $value, $fail) {
                if (!preg_match('/^[12]\d{9}$/', $value)) {
                    $fail(__('The ID number must start with 1 or 2 and be exactly 10 digits long.'));
                }
            }
        ],
    ],
    [
        'id_number.required' => 'The ID number field is required.',
        'id_number.numeric' => 'The ID number must be a number.',
        'id_number.digits' => 'The ID number must be exactly 10 digits long.',
    ]);


    // Find the user by ID number
    $user = User::where('id_number', $request->id_number)->first();

    if (!$user) {
        return redirect()->back()->with('error', __('User not found.'));
    }

    // Check if the user is already an owner
    if ($user->is_owner) {
        return redirect()->back()->with('info', __('This user is already an owner.'));
    }

    // Update the user to be an owner
    $user->update(['is_owner' => 1]);

    // Create an owner profile
    $owner = Owner::create([
        'name' => $user->name,
        'email' => $user->email,
        'full_phone' => $user->full_phone,
        'city_id' => $request->city_id,
        'user_id' => $user->id,
        'balance' => $request->balance ?? 0,
    ]);

    // Associate the owner with the broker (if needed)
    $broker_id = auth()->user()->UserBrokerData->id;
    $owner->brokers()->attach($broker_id, [
        'balance' => $request->balance ?? 0,
    ]);

    // Notify admins or perform other actions
    $this->notifyAdmins2($user);

    return redirect()->route('owners.index')->with('success', __('Owner profile added successfully.'));
}



    public function store(Request $request)
    {
        $this->ownerService->createOwner($request->all());
        return redirect()->route('Broker.Owner.index')->with('success', __('added successfully'));
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

        $Owner =  $this->ownerService->getOwnerById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Owner.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->ownerService->updateOwner($id, $request->all());
        return redirect()->route('Broker.Owner.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->ownerService->deleteOwner($id);
        return redirect()->route('Broker.Owner.index')->with('success', __('Deleted successfully'));
    }
}
