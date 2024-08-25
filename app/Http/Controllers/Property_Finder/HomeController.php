<?php

namespace App\Http\Controllers\Property_Finder;

use App\Http\Controllers\Controller;
use App\Models\FavoriteUnit;
use App\Models\Unit;
use App\Models\UnitRentalPrice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Http\Traits\Email\MailSendCode;
use  App\Email\Admin\SendOtpMail;
use App\Models\City;
use App\Models\District;
use App\Models\Feature;
use App\Models\RealEstateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewPropertyFinderNotification;
use App\Services\Admin\DistrictService;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyUsage;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitInterest;
use App\Models\UnitService as ModelsUnitService;
use App\Services\Admin\SettingService;
use App\Services\AllServiceService;
use App\Services\CityService;
use App\Services\Broker\BrokerDataService;
use App\Services\Broker\OwnerService;
use App\Services\Broker\UnitInterestService;
use App\Services\Broker\UnitService;
use App\Services\FeatureService;
use App\Services\PropertyTypeService;
use App\Services\PropertyUsageService;
use App\Services\RegionService;
use App\Services\ServiceTypeService;

use App\Services\Admin\SubscriptionService;
use App\Services\Admin\SubscriptionTypeService;
use Illuminate\Support\Facades\Storage;



class HomeController extends Controller
{


    use MailSendCode;

    protected $UnitService;
    protected $regionService;
    protected $cityService;
    protected $brokerDataService;
    protected $propertyTypeService;
    protected $propertyUsageService;
    protected $ServiceTypeService;
    protected $AllServiceService;
    protected $FeatureService;
    protected $ownerService;
    protected $settingService;
    protected $unitInterestService;
    protected $SubscriptionTypeService;

    protected $subscriptionService;
    protected $districtService;





    public function __construct(
        SettingService $settingService,
        OwnerService $ownerService,
        UnitService $UnitService,
        RegionService $regionService,
        AllServiceService $AllServiceService,
        FeatureService $FeatureService,
        CityService $cityService,
        BrokerDataService $brokerDataService,
        PropertyTypeService $propertyTypeService,
        ServiceTypeService $ServiceTypeService,
        PropertyUsageService $propertyUsageService,
        UnitInterestService $unitInterestService,
        SubscriptionTypeService $SubscriptionTypeService,
        SubscriptionService $subscriptionService,
        DistrictService $districtService
    ) {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->UnitService = $UnitService;
        $this->brokerDataService = $brokerDataService;
        $this->propertyTypeService = $propertyTypeService;
        $this->propertyUsageService = $propertyUsageService;
        $this->ServiceTypeService = $ServiceTypeService;
        $this->AllServiceService = $AllServiceService;
        $this->FeatureService = $FeatureService;
        $this->ownerService = $ownerService;
        $this->settingService = $settingService;
        $this->unitInterestService = $unitInterestService;
        $this->subscriptionService = $subscriptionService;
        $this->SubscriptionTypeService = $SubscriptionTypeService;
        $this->districtService = $districtService;
    }



    public function index()
    {
        $finder = auth()->user();
        if ($finder->is_renter) {
            $finder->assignRole('Renter');
        } elseif ($finder->is_property_finder) {
            $finder->assignRole('Property-Finder');
        }elseif ($finder->is_owner) {
            $finder->assignRole('Owner');
        }

        $favorites = FavoriteUnit::where('finder_id', $finder->id)->get();
        $units = Unit::with('Unitfavorites')
            ->whereIn('id', $favorites->pluck('unit_id'))
            ->get();
            $user = auth()->user();

            $requests = RealEstateRequest::withCount(['requestStatuses as views_count' => function ($query) {
                $query->whereNotNull('read_by');
            }])->where('user_id', $user->id)->get();

            $count = 0;



        $allItems = collect();
        $AllUnits = Unit::where('owner_id', auth()->user()->UserOwnerData->id)
        ->get();
        $projects =  Project::where('owner_id', auth()->user()->UserOwnerData->id)
        ->get();
        $properties =  Property::where('owner_id', auth()->user()->UserOwnerData->id)
        ->get();
        $AllUnits->each(function ($unit) {
            $unit->isGalleryUnit = true;

        });
        $projects->each(function ($project) {
            $project->isGalleryProject = true;
        });
        $properties->each(function ($property) {
            $property->isGalleryProperty = true;
        });

        $Items = $projects->merge($properties)->merge($AllUnits);
        $allItems = $allItems->merge($Items);

        return view('Home.Property-Finder.index', get_defined_vars());
    }

    public function create(){

    }

    public function show($id){

    }

    public function updatePropertyFinder(Request $request, $id)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'key_phone' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                'unique:users,id_number,' . $id, // Ensure ID number is unique, excluding the current user
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'phone.required' => __('The mobile field is required.'),
            'phone.unique' => __('The mobile has already been taken.'),
            'avatar.image' => __('The Image logo must be an image.'),
            'id_number.required' => 'The ID number field is required.',
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
            'id_number.unique' => 'The ID number has already been taken.', // Custom message for unique constraint
        ];

        $request->validate($rules, $messages);

        $finder = User::findOrFail($id);
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($finder->avatar) {
                $oldAvatarPath = public_path($finder->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $file = $request->file('avatar');
            $ext = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
            $finder->avatar = '/PropertyFounder/' . 'Logos/' . $ext;
        }

            $finder->name = $request->name;
            $finder->email = $request->email;
            $finder->phone = $request->phone;
            $finder->id_number = $request->id_number;
            $finder->key_phone = $request->key_phone;
            $finder->full_phone = $request->key_phone . $request->phone;

            $finder->save();

        return redirect()->route('PropertyFinder.home')->withSuccess(__('Property Finder updated successfully.'));
    }

    public function updatePassword(Request $request, $id)
    {
     $user = User::findOrFail($id);


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
        return redirect()->route('PropertyFinder.home')->withSuccess(__('Password updated successfully.'));
    }

    // public function updatePassword(Request $request, $id)
    // {
    //     $rules = [
    //         'password' => 'required|string|min:8|confirmed',
    //     ];

    //     $messages = [
    //         'password.required' => __('The new password field is required.'),
    //         'password.min' => __('The new password must be at least 8 characters.'),
    //         'password.confirmed' => __('The new password confirmation does not match.'),
    //     ];

    //     $request->validate($rules, $messages);

    //     $user = User::findOrFail($id);

    //     if (!Hash::check($request->password, $user->password)) {
    //         return back()->withErrors(['password' => __('The current password is incorrect.')]);
    //     }

    //     $user->password = bcrypt($request->new_password);
    //     $user->save();

    //     return redirect()->route('PropertyFinder.home')->withSuccess(__('Password updated successfully.'));
    // }



    public function sendOtp(Request $request)
    {
        $email = $request->input('email');

        $userExists = User::where('email', $email)->exists();

        if (!$userExists) {
            $otp = mt_rand(100000, 999999);
            // $otp = 555555; // Static OTP for testing
            session(['otp' => $otp]);
            $this->MailSendCode($request->email, $otp);
            return response()->json(['message' => 'OTP sent successfully']);
        } else {
            return response()->json(['message' => 'This email is already registered.'], 400);
        }
    }


    public function verifyOtp(Request $request)
{
    $email = $request->input('email');
    $otp = $request->input('otp');
    if ($otp == session('otp')) {
        return response()->json(['message' => 'OTP verified']);
    } else {
        return response()->json(['error' => 'Invalid OTP'], 422);
    }
}

public function resendOtp(Request $request)
{
    $email = $request->input('email');
    $otp = session('otp');
    $this->MailSendCode($request->email, $otp);
    return response()->json(['message' => 'OTP resent successfully']);
}


// public function registerPropertyFinder(Request $request)
// {
//     $name = $request->input('name');
//     $email = $request->input('email_hidden');
//     $password = Hash::make($request->input('password'));
//     // Create Property Finder logic
//     $propertyFinder = PropertyFinder::create([
//         'name' => $name,
//         'email' => $email,
//         'password' => $password,
//     ]);
//     return response()->json(['message' => 'Property Finder created successfully']);
// }


public function registerPropertyFinder(Request $request)
{

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        // 'phone' => [
        //     'required',
        //     'max:25'
        // ],
        // 'full_phone' => [
        //     'required',
        //     Rule::unique('users'),
        //     'max:25'
        // ],
        'password' => 'required|string|max:255|confirmed',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ];

    $messages = [
        'name.required' => __('The name field is required.'),
        'email.required' => __('The email field is required.'),
        'email.unique' => __('The email has already been taken.'),
        'full_phone.required' => __('The mobile field is required.'),
        'full_phone.unique' => __('The mobile has already been taken.'),
        'password.required' => __('The password field is required.'),
        'password.confirmed' => __('The password confirmation does not match.'),
        'avatar.image' => __('The broker logo must be an image.')
    ];

    $request->validate($rules, $messages);

    $request_data = [];

    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $ext  =  uniqid() . '.' . $file->clientExtension();
        $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
        $request_data['avatar'] = '/PropertyFounder/' . 'Logos/' . $ext;
    }

    $user = User::create([
        'is_property_finder' => 1,
        'name' => $request->name,
        'phone' => $request->phone ?? null,
        'key_phone' => $request->key_phone ?? null,
        'full_phone' => $request->full_phone ?? null,
        'email' => $request->email,
        'user_name' => uniqid(),
        'password' => bcrypt($request->password),
        'avatar' => $request_data['avatar'] ?? null,
    ]);

    $this->notifyAdmins2($user);
    auth()->loginUsingId($user->id);

    return response()->json([
        'message' => 'Property Finder registered successfully.',
        'redirect' => route('PropertyFinder.home')
    ]);

    // return response()->json(['message' => 'Property Finder created successfully']);
}

protected function notifyAdmins2(User $user)
{
    $admins = User::where('is_admin', true)->get();
    foreach ($admins as $admin) {
        Notification::send($admin, new NewPropertyFinderNotification($user));
    }
}

public function GetDistrictsByCity($id)
{
    // $districts = District::where('city_id', $id)->get();
    $districts = $this->districtService->getDistrictsByCity($id);

    return view('Admin.settings.Region.inc._district', get_defined_vars());
}

public function createUnit()
    {
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        $projects = $this->brokerDataService->getProjectsForOwners();
        $properties = $this->brokerDataService->getPropertiesForOwners();
        return view('Home.Owners.unit.create', get_defined_vars());
    }

    public function storeUnit(Request $request)
    {
        // return $request;

        $rules = [];
        $rules = [
            'number_unit' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'price' => 'digits_between:0,10',
            'monthly' => 'digits_between:0,8',
            'instrument_number' => [
                'nullable',
                Rule::unique('units'),
                'max:25'
            ],
            'daily' => 'digits_between:0,8',
            'quarterly' => 'digits_between:0,8',
            'midterm' => 'digits_between:0,10',
            'yearly' => 'digits_between:0,10',

        ];
        $messages = [
            'number_unit.required' => 'The number unit field is required.',
            'number_unit.string' => 'The number unit must be a string.',
            'number_unit.max' => 'The number unit may not be greater than :max characters.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than :max characters.',
            'city_id.required' => 'The city ID field is required.',
            'city_id.exists' => 'The selected city ID is invalid.',
            'owner_id.required' => 'The owner ID field is required.',
            'owner_id.exists' => 'The selected owner ID is invalid.',
            'instrument_number.unique' => 'The instrument number has already been taken.',
            'instrument_number.max' => 'The instrument number may not be greater than :max characters.',
            'price' => 'price must be smaller than or equal to 10 numbers.',
            'monthly' => 'Monthly price must be smaller than or equal to 8.',
            'daily' => 'Monthly price must be smaller than or equal to 8.',
            'quarterly' => 'Monthly price must be smaller than or equal to 8.',
            'midterm' => 'Monthly price must be smaller than or equal to 10.',
            'yearly' => 'Monthly price must be smaller than or equal to 10.',


        ];
       $request->validate($rules, $messages);
        $data = $request->all();
        $unit_data = $data;

        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        // unset($unit_data['videos']);
        unset($unit_data['service_id']);
        unset($unit_data['monthly']);

            $unit_data['show_gallery'] = 0;
            $unit_data['ad_license_status'] ='InValid';



        if (isset($data['daily_rent'])) {
            $unit_data['daily_rent'] = $data['daily_rent'] == 'on' ? 1 : 0;
        } else {
            $unit_data['daily_rent'] = 0;
        }

        if (isset($unit_data['unit_masterplan'])) {
            $unitMasterplan = $unit_data['unit_masterplan'];
            $ext = $unitMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $unitMasterplan->move(public_path('/Brokers/Projects/Units/'), $masterplanName);
            $unit_data['unit_masterplan'] = '/Brokers/Projects/Units/' . $masterplanName;
        }

        if (isset($unit_data['video'])) {
            $video = $unit_data['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = uniqid() . '.' . $ext;
            $video->move(public_path('/Brokers/Projects/Unit/Video/'), $videoName);
            $unit_data['video'] = '/Brokers/Projects/Unit/Video/' . $videoName;
        }

        $unit = Unit::create($unit_data);
        if (isset($data['service_id'])) {
            foreach ($data['service_id'] as  $service) {
                ModelsUnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
            }
        }
        UnitRentalPrice::create([
            'unit_id' => $unit->id,
            'daily' => $data['monthly'] / 30,
            'monthly' => $data['monthly'],
            'quarterly' => $data['monthly'] * 3,
            'midterm' => $data['monthly'] * 6,
            'yearly' => $data['monthly'] * 12,
        ]);
        if (isset($data['name'])) {
            foreach ($data['name'] as $index => $Feature_name) {
                $Feature =    Feature::where('name', $Feature_name)->first();
                if (!$Feature) {
                    $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
                }
                UnitFeature::create(['feature_id' => $Feature->id, 'unit_id' => $unit->id, 'qty' => $data['qty'][$index]]);
            }
        }
        if (isset($data['images'])) {
            $images = $data['images'];
            if ($images) {
                foreach ($images as $image) {
                    $ext = $image->getClientOriginalExtension();
                    $filename = uniqid() . '.' . $ext;
                    $image->move(public_path() . '/Brokers/Projects/Unit/Images/' . $unit->number_unit . '/', $filename);
                    UnitImage::create([
                        'image' => '/Brokers/Projects/Unit/Images/' . $unit->number_unit . '/' . $filename,
                        'unit_id' => $unit->id,
                    ]);
                }
            }
        }

        return redirect()->route('Broker.Unit.index')->with('success', __('added successfully'));

    }

    public function GetCitiesByRegion($id)
    {
        // $cities = City::where('region_id', $id)->get();
        $cities =City::where('region_id', $id)->get();

        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }


}
