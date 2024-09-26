<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\Owner;
use App\Models\OwnerOfficeBroker;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Models\SubscriptionTypeRole;
use App\Models\SystemInvoice;
use App\Models\User;
use App\Notifications\Admin\NewPropertyFinderNotification;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Broker\OwnerService;
use App\Services\RegionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

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
        // $owners = $this->ownerService->getAllByBrokerId(auth()->user()->UserBrokerData->id);
        $broker = Broker::with('owners')->findOrFail(auth()->user()->UserBrokerData->id);
        $owners = $broker->owners;
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
                            'message' => __('Click on Client Data, can not add again in the same account.'),
                            'user' => $user,
                        'id_number'=>$idNumber

                        ])->render()
                    ]);
                } else {
                    return response()->json([
                        'html' => view('Broker.ProjectManagement.Owner.inc.search-result-modal', [
                            'message' => __('Click on Client Data, Add as Owner the patient added to the Owners list.'),
                            'user' => $user,
                            'id_number'=>$idNumber
                        ])->render()
                    ]);
                }
            } else {
                return response()->json([
                    'html' => view('Broker.ProjectManagement.Owner.inc.search-result-modal', [
                        'message' => __('Click on Client Data, Add as Owner the patient added to the Owners list.'),
                        'user' => $user,
                        'id_number'=>$idNumber
                    ])->render()
                ]);
            }
        } else {
            return response()->json([
                'html' => view('Broker.ProjectManagement.Owner.inc._addRenter', [
                    'message' => __('This Owner is not registered'),
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
        return redirect()->route('Broker.Owner.index')->with('success', __('User not found.'));
    }

    $city_id = null;
    if ($user->UserBrokerData) {
        $city_id = $user->UserBrokerData->CityData->id ?? null;
    } elseif ($user->UserOfficeData) {
        $city_id = $user->UserOfficeData->CityData->id ?? null;
    } elseif ($user->UserOwnerData) {
        $city_id = $user->UserOwnerData->CityData->id ?? null;
    } elseif ($user->UserRenterData) {
        $city_id = $user->UserRenterData->CityData->id ?? null;
    } elseif ($user->UserEmployeeData) {
        $city_id = $user->UserEmployeeData->CityData->id ?? null;
    }

    if ($user->is_owner) {
        $owner_id=$user->UserOwnerData->id;
        $owner = Owner::findOrFail($owner_id);
        $broker_id = auth()->user()->UserBrokerData->id;
        $owner->brokers()->attach($broker_id, [
            'balance' => $request->balance ?? 0,
        ]);
        return redirect()->route('Broker.Owner.index')->with('success', __('Owner profile added successfully.'));

    }else{
        $user->update(['is_owner' => 1]);
        $user->assignRole('Owner');

        $owner = Owner::create([
            'name' => $user->name,
            'email' => $user->email,
            'key_phone' => $user->key_phone ?? null,
            'phone' => $user->phone ?? null,
            'full_phone' => $user->full_phone,
            'city_id' => $city_id ?? $request->city_id,
            'user_id' => $user->id,
            'balance' => $request->balance ?? 0,
        ]);



        $RolesIds = Role::whereIn('name', ['Owner'])->pluck('id')->toArray();
        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
        $subscriptionType = SubscriptionType::where('is_deleted', 0)
        ->where('status', 1)
        ->where('new_subscriber', '1')
        ->whereIn('id', $RolesSubscriptionTypeIds)
        ->first();
        $subscription_type_id = $subscriptionType->id;

        $subscriptionType = SubscriptionType::find($subscription_type_id);
        $startDate = Carbon::now();
        $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');

        if ($subscriptionType->price > 0) {
            $SubType = 'paid';
            $status = 'pending';
        } else {
            $SubType = 'free';
            $status = 'active';
        }
        $subscription = Subscription::create([
            'owner_id' => $owner->id,
            'subscription_type_id' => $subscription_type_id,
            'status' => $status,
            'is_start' => $status == 'pending' ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => $endDate,
            'total' => '200'
        ]);

        foreach ($subscriptionType->sections()->get() as $section_id) {
            SubscriptionSection::create([
                'section_id' => $section_id->id,
                'subscription_id' => $subscription->id,
            ]);
        }
        $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');

        $delimiter = '-';
        if (!$Last_invoice_ID) {
            $new_invoice_ID = '00001';
        } else {
            $result = explode($delimiter, $Last_invoice_ID);
            $number = (int)$result[1] + 1;
            $new_invoice_ID = str_pad($number % 10000, 5, '0', STR_PAD_LEFT);
        }
        $Invoice =   SystemInvoice::create([
            'owner_id' => $owner->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $SubType,
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ]);



        $broker_id = auth()->user()->UserBrokerData->id;
        $owner->brokers()->attach($broker_id, [
            'balance' => $request->balance ?? 0,
        ]);

        $this->notifyAdmins2($user);


        return redirect()->route('Broker.Owner.index')->with('success', __('Owner profile added successfully.'));

    }

    }

    protected function notifyAdmins2(User $user)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewPropertyFinderNotification($user));
        }
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

        $Owner =  $this->ownerService->getOwnerById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Broker.ProjectManagement.Owner.show', get_defined_vars());
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

    // public function destroy(string $id)
    // {
    //     $this->ownerService->deleteOwner($id);
    //     return redirect()->route('Broker.Owner.index')->with('success', __('Deleted successfully'));
    // }

    public function destroy(string $id)
    {
        $owner = $this->ownerService->getOwnerById($id);
        $UserId = auth()->user()->id;
        $brokerId = auth()->user()->UserBrokerData->id;

        if ($owner->user_id === $UserId) {
            OwnerOfficeBroker::where('owner_id', $owner->id)
                ->where('broker_id', $brokerId)
                ->delete();

            return redirect()->route('Broker.Owner.index')->with('success', __('You have been removed as an owner from your broker account.'));
        }

        $ownerInOtherAccounts = OwnerOfficeBroker::where('owner_id', $owner->id)
            ->where('broker_id', '!=', $brokerId)
            ->exists();

        if ($ownerInOtherAccounts) {
            OwnerOfficeBroker::where('owner_id', $owner->id)
                ->where('broker_id', $brokerId)
                ->delete();

            return redirect()->route('Broker.Owner.index')->with('success', __('Owner removed from your broker account.'));
        }

        $this->ownerService->deleteOwner($id);
        return redirect()->route('Broker.Owner.index')->with('success', __('Deleted successfully'));
    }



}
