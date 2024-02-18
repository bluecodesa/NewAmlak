<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\City;
use App\Models\Office;
use App\Models\Region;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\SubscriptionTypeRole;
use App\Models\SystemInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscribers = Subscription::with(['OfficeData.UserData', 'BrokerData.UserData'])->get();
        $cities = City::all();
        $subscriptionTypes = SubscriptionType::all();
        return view('Admin.subscribers.index', get_defined_vars());
    }

    // $RolesIds = Role::whereIn('name', ['Office-Admin'])->pluck('id')->toArray();

    // $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();

    // $subscriptionTypes = SubscriptionType::whereIn('id', $RolesSubscriptionTypeIds)->get();


    // $PendingPayment =   Auth::user()->UserBrokerData->UserSubscriptionPending ?? '';
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        $subscriptionTypes = SubscriptionType::whereHas('Roles', function ($query) {
            $query->where('name', 'Office-Admin');
        })->get();
        return view('Admin.admin.subscriptions.create', get_defined_vars());
    }

    public function createBroker()
    {
        $Regions = Region::all();
        $cities = City::all();

        $RolesIds = Role::whereIn('name', ['RS-Broker'])->pluck('id')->toArray();

        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();

        $subscriptionTypes = SubscriptionType::whereIn('id', $RolesSubscriptionTypeIds)->get();
        return view('Admin.admin.subscriptions.create_broker', get_defined_vars());
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'city_id' => 'required|exists:cities,id',
            'company_logo' => 'required|file',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'CRN' => [
                'required',
                Rule::unique('offices'),
                'max:25'
            ],
            'presenter_number' => [
                'required',
                Rule::unique('offices'),
                'max:25'
            ],
            'presenter_name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
        $messages = [
            'name.required' => 'The ' . __('name') . ' field is required.',
            'email.required' => 'The ' . __('email') . ' field is required.',
            'presenter_number.required' => 'The ' . __('Company representative number') . ' field is required.',
        ];
        $request->validate($rules, $messages);

        if ($request->company_logo) {
            $file = $request->File('company_logo');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Offices/' . 'Logos/', $ext);
            $request_data['company_logo'] = '/Offices/' . 'Logos/' . $ext;
        }

        $user = User::create([
            'is_office' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'avatar' => $request_data['company_logo'],
        ]);

        $office = Office::create([
            'user_id' => $user->id,
            'CRN' => $request->CRN,
            'company_name' => $user->name,
            'city_id' => $request->city_id,
            'created_by' => Auth::id(),
            'presenter_name' => $request->presenter_name,
            'presenter_number' => $request->presenter_number,
            'company_logo' => $request_data['company_logo'],
        ]);
        $subscriptionType = SubscriptionType::find($request->subscription_type_id); // Or however you obtain your instance
        $startDate = Carbon::now();
        $endDate = $subscriptionType->calculateEndDate($startDate)->format('Y-m-d');
        if ($subscriptionType->price > 0) {
            $SubType = 'paid';
            $status = 'pending';
        } else {
            $SubType = 'free';
            $status = 'active';
        }
        Subscription::create([
            'office_id' => $office->id,
            'subscription_type_id' => $request->subscription_type_id,
            'status' => $status,
            'is_start' => $status == 'pending' ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => $endDate,
            'total' => '200'
        ]);

        SystemInvoice::create([
            'office_id' => $office->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $SubType,
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV_' . uniqid(),
        ]);
        return redirect()->route('Admin.Subscribers.index')
            ->withSuccess(__('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    function SuspendSubscription(Request $request, $id)
    {

        Subscription::find($id)->update([
            'is_suspend' => $request->is_suspend,
        ]);

        if ($request->is_suspend == 0) {
            return redirect()->route('Admin.Subscribers.index')
                ->withSuccess(__('Subscription has been activated'));
        } else {
            return redirect()->route('Admin.Subscribers.index')
                ->withSuccess(__('Subscription has been suspended'));
        }
    }

    public function edit($id)
    {
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
        $user =  Subscription::find($id)->OfficeData;
        if ($user) {
            $user->UserData->delete();
        } else {
            Subscription::find($id)->BrokerData->UserData->delete();
        }
        return redirect()->route('Admin.Subscribers.index')->with('success', __('added successfully'));
    }


    public function storeBroker(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'mobile' => 'required|unique:brokers,mobile|digits:9',
            'city_id' => 'required|exists:cities,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'license_number' => 'required|string|max:255|unique:brokers,broker_license',
            'password' => 'required|string|max:255|confirmed',
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'mobile.required' => __('The mobile field is required.'),
            'license_number.required' => __('The license number field is required.'),
            'password.required' => __('The password field is required.'),
        ];

        $request->validate($rules, $messages);

        $user = User::create([
            'is_broker' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
        ]);

        $broker = Broker::create([
            'user_id' => $user->id,
            'broker_license' => $request->license_number,
            'mobile' => $request->mobile,
            'city_id' => $request->city_id,
            'id_number' => $request->id_number,
        ]);

        $subscriptionType = SubscriptionType::find($request->subscription_type_id); // Or however you obtain your instance
        $startDate = Carbon::now();
        $endDate = $subscriptionType->calculateEndDate($startDate)->format('Y-m-d');
        if ($subscriptionType->price > 0) {
            $SubType = 'paid';
            $status = 'pending';
        } else {
            $SubType = 'free';
            $status = 'active';
        }
        Subscription::create([
            'broker_id' => $broker->id,
            'subscription_type_id' => $request->subscription_type_id,
            'status' => $status,
            'is_start' => $status == 'pending' ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => $endDate,
            'total' => '200'
        ]);
        SystemInvoice::create([
            'broker_id' => $broker->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $SubType,
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV_' . uniqid(),
        ]);


        return redirect()->route('Admin.Subscribers.index')->withSuccess(__('Broker created successfully.'));
    }

    public function viewPending()
    {
        return view('Home.Payments.pending_payment');
    }
}