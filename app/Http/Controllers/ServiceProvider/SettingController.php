<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Fal;
use App\Models\FalLicenseUser;
use App\Models\Gallery;
use App\Models\NotificationSetting;
use App\Models\Office;
use App\Models\ServiceProvider;
use App\Models\Subscription;
use App\Services\Admin\EmailSettingService;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Services\CityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\Broker\UnitService;
use App\Services\ServiceProvider\SettingService;
use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Admin\FalLicenseService;
use Illuminate\Support\Facades\Hash;

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
        $serviceProvider = auth()->user()->UserServiceProviderData;
        $settings = $this->settingService->getSetting($serviceProvider);
        $city = $serviceProvider->CityData;
        $region = $city->RegionData ?? [];

        return view('ServiceProvider.settings.index', get_defined_vars());
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
        $data = $request->all();
        $this->settingService->updateProfileSetting($request, $id);
        return redirect()->route('ServiceProvider.Setting.index')->withSuccess(__('Update successfully'));
    }

    public function updateProfileSetting(Request $request, string $id)
    {
        $data = $request->all();
        $this->settingService->updateProfileSetting($request, $id);
        return redirect()->route('Office.Setting.index')->withSuccess(__('Update successfully'));
    }


    public function updatePassword(Request $request, $id)
    {
        $serviceProvider = ServiceProvider::findOrFail($id);

        $user = $serviceProvider->userData;

        $rules = [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];

        $messages = [
            'current_password.required' => __('The current password field is required.'),
            'password.required' => __('The new password field is required.'),
            'password.min' => __('The new password must be at least 8 characters.'),
            'password.confirmed' => __('The new password confirmation does not match.'),
        ];

        $request->validate($rules, $messages);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('The current password is incorrect.')]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect()->route('ServiceProvider.Setting.index')->withSuccess(__('Password updated successfully.'));
    }

    public function createPassword(Request $request, $id)
    {
        $serviceProvider = ServiceProvider::findOrFail($id);

        $user = $serviceProvider->userData;

        $rules = [
            'password' => 'required|string|min:8|confirmed',
        ];

        $messages = [
            'password.required' => __('The new password field is required.'),
            'password.min' => __('The new password must be at least 8 characters.'),
            'password.confirmed' => __('The new password confirmation does not match.'),
        ];

        $request->validate($rules, $messages);


        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect()->route('ServiceProvider.Setting.index')->withSuccess(__('Password updated successfully.'));
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

        $data = $request->all();
        $this->settingService->updateOffice($data, $id);
        return redirect()->route('Office.Setting.index')->withSuccess(__('Update successfully.'));
    }

    public function createFalLicense()
    {
        // $createdTypes = FalLicenseUser::where('user_id', auth()->user()->id)->pluck('fal_id');
        // $Faltypes = Fal::whereNotIn('id', $createdTypes)->get();
        // $falLicenses=FalLicenseUser::where('user_id',auth()->user()->id)->get();
        $Faltypes = $this->FalLicenseService->getUnusedLicenseTypes(auth()->id());
        $falLicenses = $this->FalLicenseService->getUserLicenses(auth()->id());
        $Licenses = $this->FalLicenseService->getLicensesAllValid();

        return view('Office.settings.inc.FalLicense.create', get_defined_vars());
    }

    public function editFalLicense($id)
    {

        $Faltypes = $this->FalLicenseService->getAll();
        $falLicense = FalLicenseUser::findOrFail($id);

        return view('Office.settings.inc.FalLicense.edit', get_defined_vars());
    }

    public function storeFalLicense(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'ad_license_number' => [
                'required',
                'numeric',
                Rule::unique('fallicenseusers')
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

        $this->FalLicenseService->createFalLicenseUser([
            'user_id' => auth()->id(),
            'ad_license_number' => $validatedData['ad_license_number'],
            'ad_license_expiry' => $validatedData['ad_license_expiry'],
            'fal_id' => $validatedData['fal_id'],
            'ad_license_status' => 'valid',
        ]);

        // Redirect with success message
        return redirect()->route('Office.Setting.index')->withSuccess(__('License created successfully.'));
    }


    public function updateFalLicense(Request $request, $id)
    {
        $user = auth()->user();

        $rules = [
            'ad_license_number' => [
                'required',
                'numeric',
                Rule::unique('fallicenseusers')->ignore($id)
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

        $falLicenseUser = FalLicenseUser::findOrFail($id);

        $falLicenseUser->update([
            'fal_id' => $validatedData['fal_id'],
            'ad_license_number' => $validatedData['ad_license_number'],
            'ad_license_expiry' => $validatedData['ad_license_expiry'],
            'ad_license_status' => 'valid',
        ]);

        // Redirect with success message
        return redirect()->route('Office.Setting.index')->withSuccess(__('License updated successfully.'));
    }
    public function deleteFalLicense($id)
    {
        $falLicense = FalLicenseUser::destroy($id);

        return redirect()->route('Office.Setting.index')->withSuccess(__('Deleted successfully'));
    }

}
