<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Services\CityService;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

    protected $regionService;
    protected $cityService;

    public function __construct( RegionService $regionService, CityService $cityService)
    {

        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }
    public function index()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $user = Auth::user()->UserBrokerData->userData;
        $broker=Broker::find(Auth::user()->UserBrokerData->id);
        $city=$broker->CityData;
        $region=$city->RegionData;

        $subscription = Subscription::where('broker_id', Auth::user()->UserBrokerData->id)->first();

        return view('Broker.settings.index',get_defined_vars());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $subscriber =Subscription::find($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'city_id' => 'required|exists:cities,id',
            'company_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'mobile' => 'required|digits:9|unique:brokers,mobile,'.$id,
            'license_number' => 'required|string|max:255|unique:brokers,broker_license,'.$id,
            'password' => 'nullable|string|max:255|confirmed',
        ];


        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'mobile.required' => __('The mobile field is required.'),
            'license_number.required' => __('The license number field is required.'),
        ];

        $request->validate($rules, $messages);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path() . '/Brokers/Logos/', $fileName);
            $user->company_logo = '/Brokers/Logos/' . $fileName;
        }
        $user->save();

        $broker = Broker::findOrFail($user->broker->id);
        $broker->broker_license = $request->license_number;
        $broker->mobile = $request->mobile;
        $broker->city_id = $request->city_id;
        $broker->id_number = $request->id_number;
        $broker->save();

        return redirect()->route('Broker.Setting')->withSuccess(__('Broker updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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


        return redirect()->route('login')->withSuccess(__('Broker created successfully.'));
    }

}

