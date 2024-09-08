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
use App\Services\Admin\SubscriptionTypeService;
use Illuminate\Support\Facades\Hash;
use App\Services\Admin\FalLicenseService;
use App\Models\FalLicenseUser;


class SettingController extends Controller
{
    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $EmailSettingService;
    protected $settingService;
    protected $subscriptionService;
    protected $SubscriptionTypeService;
    protected $FalLicenseService;



    public function __construct(
        SubscriptionService $subscriptionService,
        SettingService $settingService,
        UnitService $UnitService,
        RegionService $regionService,
        CityService $cityService,
        EmailSettingService $EmailSettingService,
        SubscriptionTypeService $SubscriptionTypeService,
        FalLicenseService $FalLicenseService

    ) {
        $this->UnitService = $UnitService;
        $this->regionService = $regionService;
        $this->EmailSettingService = $EmailSettingService;
        $this->cityService = $cityService;
        $this->settingService = $settingService;
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->FalLicenseService = $FalLicenseService;


        $this->middleware(['role_or_permission:read-building'])->only(['index']);
    }
    public function index()
    {

        $EmailSettingService = $this->EmailSettingService->getAll();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $broker = auth()->user()->UserBrokerData;
        $settings = $this->settingService->getBrokerSettings($broker);
        $city = $broker->CityData;
        $region = $city->RegionData ?? [];
        $gallery = $settings['gallery'];
        $NotificationSetting = $settings['notificationSettings'];
        $subscriber = $this->subscriptionService->findSubscriptionByBrokerId(auth()->user()->UserBrokerData->id);
        $sectionNames = [];
        if ($subscriber) {
            $subscriptionType = $this->SubscriptionTypeService->getSubscriptionTypeById($subscriber->subscription_type_id);
            $hasRealEstateGallerySection = $subscriptionType->sections()->get();
            $sectionNames = $hasRealEstateGallerySection->pluck('name')->toArray();
        }

        $UserSubscriptionTypes = $this->SubscriptionTypeService->getGallerySubscriptionTypes();
        $Faltypes = $this->FalLicenseService->getAll();
        $falLicenses=FalLicenseUser::where('user_id',auth()->user()->UserBrokerData->id)->get();

        // return Auth::user()->UserBrokerData->UserSubscription->subscription_type_id;
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
        // return $request->all();
        $data = $request->all();
        $this->settingService->updateBroker($data, $id);
        return redirect()->route('Broker.Setting.index')->withSuccess(__('Updated successfully.'));
    }

    public function updatePassword(Request $request, $id)
    {
        $broker = Broker::findOrFail($id);

        $user = $broker->userData;

        $rules = [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Define custom error messages
        $messages = [
            'current_password.required' => __('The current password field is required.'),
            'password.required' => __('The new password field is required.'),
            'password.min' => __('The new password must be at least 8 characters.'),
            'password.confirmed' => __('The new password confirmation does not match.'),
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('The current password is incorrect.')]);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect()->route('Broker.Setting.index')->withSuccess(__('Password updated successfully.'));
    }

    public function createFalLicense()
    {
        //
        $Faltypes = $this->FalLicenseService->getAll();
        $falLicenses=FalLicenseUser::where('user_id',auth()->user()->UserBrokerData->id)->get();

        // return Auth::user()->UserBrokerData->UserSubscription->subscription_type_id;
        return view('Broker.settings.inc.FalLicense.create', get_defined_vars());
    }

    public function storeFalLicense(Request $request)
{
    $user = auth()->user();

    $rules = [
        'ad_license_number' => [
            'required',
            'numeric',
            Rule::unique('fallicenseUsers')
        ],
        'ad_license_expiry' => 'required|date|after_or_equal:today',
        'fal_id' => 'required|exists:fals,id',
    ];

    $messages = [
        'ad_license_number.required' => 'The license number is required.',
        'ad_license_number.unique' => 'The license number has already been taken.',
        'ad_license_number.numeric' => 'The license number must be a number.',
        'ad_license_expiry.required' => 'The license expiry date is required.',
        'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
        'ad_license_expiry.after_or_equal' => 'The license expiry date must be today or a future date.',
        'fal_id.required' => 'The Fal License type is required.',
        'fal_id.exists' => 'The selected Fal License type is invalid.',
    ];

    $validatedData = $request->validate($rules, $messages);

    FalLicenseUser::create(
        ['user_id' => $user->id],
        [
            'fal_id' => $validatedData['fal_id'],
            'ad_license_number' => $validatedData['ad_license_number'],
            'ad_license_expiry' => $validatedData['ad_license_expiry'],
            'ad_license_status' => 'valid',
        ]
    );


    return redirect()->route('Broker.Setting.index')->withSuccess(__('License created successfully.'));
}


public function updateFalLicense(Request $request, $id)
{
    dd($request);
    $broker = Broker::findOrFail($id);
    $user = $broker->userData;

    $rules = [
        'ad_license_number' => [
            'required',
            'numeric',
            Rule::unique('fallicenseUsers')->ignore($id) // Ignore the current user's license
        ],
        'ad_license_expiry' => 'required|date|after_or_equal:today',
        'fal_id' => 'required|exists:fals,id',
    ];

    $messages = [
        'ad_license_number.required' => 'The license number is required.',
        'ad_license_number.unique' => 'The license number has already been taken.',
        'ad_license_number.numeric' => 'The license number must be a number.',
        'ad_license_expiry.required' => 'The license expiry date is required.',
        'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
        'ad_license_expiry.after_or_equal' => 'The license expiry date must be today or a future date.',
        'fal_id.required' => 'The Fal License type is required.',
        'fal_id.exists' => 'The selected Fal License type is invalid.',
    ];

    $validatedData = $request->validate($rules, $messages);


    FalLicenseUser::updateOrCreate(
        ['user_id' => $user->id],
        [
            'fal_id' => $validatedData['fal_id'],
            'ad_license_number' => $validatedData['ad_license_number'],
            'ad_license_expiry' => $validatedData['ad_license_expiry'],
            'ad_license_status' => 'Valid',
        ]
    );


    return redirect()->route('Broker.Setting.index')->withSuccess(__('License updated successfully.'));
}

}
