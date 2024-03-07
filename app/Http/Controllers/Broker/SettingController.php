<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\Gallery;
use App\Models\NotificationSetting;
use App\Models\Office;
use App\Models\Subscription;
use App\Services\Admin\EmailSettingService;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Services\CityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\Broker\UnitService;
use App\Services\Broker\SettingService;
use App\Services\Admin\SubscriptionService;




class SettingController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $EmailSettingService;
    protected $settingService;
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService,SettingService $settingService,UnitService $UnitService, RegionService $regionService, CityService $cityService, EmailSettingService $EmailSettingService,)
    {
        $this->UnitService = $UnitService;
        $this->regionService = $regionService;
        $this->EmailSettingService = $EmailSettingService;
        $this->cityService = $cityService;
        $this->settingService = $settingService;
        $this->subscriptionService = $subscriptionService;

    }
    public function index()
    {

        $EmailSettingService = $this->EmailSettingService->getAll();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $broker = Auth::user()->UserBrokerData;
        $city = $broker->CityData;
        $region = $city->RegionData;
        $subscription = Subscription::where('broker_id', $broker->id)->first();
        $gallery = Gallery::where('broker_id', $broker->id)->first();
        $NotificationSetting  = NotificationSetting::all();
        $user = Auth::user()->UserBrokerData->userData;
        $brokerSettings = $this->settingService->getBrokerSettings(Auth::user()->UserBrokerData);

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
        $subscriber = Subscription::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

       }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateBroker(Request $request, $id)
    {
        $broker = Broker::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($broker->user_id),
            ],
            'mobile' => 'required|digits:9|unique:brokers,mobile,'.$id,
            'city_id' => 'required|exists:cities,id',
            'broker_license' => 'required|string|max:255|unique:brokers,broker_license,'.$id,
            'password' => 'nullable|string|max:255|confirmed',
            'broker_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];



        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'mobile.required' => __('The mobile field is required.'),
            'mobile.unique' => __('The mobile has already been taken.'),
            'mobile.digits' => __('The mobile must be 9 digits.'),
            'broker_license.required' => __('The broker_license field is required.'),
            'broker_license.unique' => __('The broker_license has already been taken.'),
            'password.required' => __('The password field is required.'),
            'broker_logo.image' => __('The broker logo must be an image.'),
            'city_id.required' => 'The city field is required.',
            'city_id.exists' => 'The selected city is invalid.',
        ];
        $request->validate($rules, $messages);

        $broker = Broker::findOrFail($id);
        $broker->update([
            'broker_license' => $request->broker_license,
            'mobile' => $request->mobile,
            'city_id' => $request->city_id,
            'id_number' => $request->id_number,
        ]);

        $user = $broker->UserData();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        if ($request->hasFile('broker_logo')) {
            $file = $request->file('broker_logo');
            $ext = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Brokers/' . 'Logos/', $ext);
            $broker->update(['broker_logo' => '/Brokers/' . 'Logos/' . $ext]);
        }

        return redirect()->route('Broker.Setting.index')->withSuccess(__('Updated successfully.'));
    }




}
