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

class SettingController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $EmailSettingService;
    public function __construct(UnitService $UnitService, RegionService $regionService, CityService $cityService, EmailSettingService $EmailSettingService,)
    {
        $this->UnitService = $UnitService;

        $this->regionService = $regionService;
        $this->EmailSettingService = $EmailSettingService;
        $this->cityService = $cityService;
    }
    public function index()
    {
        $EmailSettingService = $this->EmailSettingService->getAll();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $user = Auth::user()->UserBrokerData->userData;
        $broker = Broker::find(Auth::user()->UserBrokerData->id);
        $city = $broker->CityData;
        $region = $city->RegionData;
        $subscription = Subscription::where('broker_id', Auth::user()->UserBrokerData->id)->first();
        $gallery = Gallery::where('broker_id', Auth::user()->UserBrokerData->id)->first();
        $NotificationSetting = NotificationSetting::all();

        return view('Broker.settings.index', get_defined_vars());
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

        $broker = Broker::findOrFail($id);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($broker->user_id),
                'max:255',
            ],
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            // Add more custom error messages as needed...
        ];

        $request->validate($rules, $messages);

        // Update user
        $broker->user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Update other fields as needed...
        ]);

        // Update broker
        $broker->update([
            'broker_license' => $request->license_number,
            'mobile' => $request->mobile,
            'city_id' => $request->city_id,
            // Update other fields as needed...
        ]);

        return redirect()->route('Broker.Setting')->withSuccess(__('Broker updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function updateOffice(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($office->user_id),
                'max:255',
            ],
            // Add more validation rules as needed...
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            // Add more custom error messages as needed...
        ];

        $request->validate($rules, $messages);

        // Update user
        $office->user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Update other fields as needed...
        ]);

        // Update office
        $office->update([
            'CRN' => $request->CRN,
            'city_id' => $request->city_id,
            // Update other fields as needed...
        ]);

        return redirect()->route('login')->withSuccess(__('Office updated successfully.'));
    }

    public function updateBroker(Request $request, $id)
    {
        $broker = Broker::findOrFail($id);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($broker->user_id),
                'max:255',
            ],
            // Add more validation rules as needed...
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            // Add more custom error messages as needed...
        ];

        $request->validate($rules, $messages);

        // Update user
        $broker->user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Update other fields as needed...
        ]);

        // Update broker
        $broker->update([
            'broker_license' => $request->license_number,
            'mobile' => $request->mobile,
            'city_id' => $request->city_id,
            // Update other fields as needed...
        ]);

        return redirect()->route('login')->withSuccess(__('Broker updated successfully.'));
    }
}