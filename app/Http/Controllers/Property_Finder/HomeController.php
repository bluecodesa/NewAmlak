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
use App\Models\Owner;
use App\Models\RealEstateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewPropertyFinderNotification;
use App\Services\Admin\DistrictService;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyUsage;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\UnitFeature;
use App\Models\UnitImage;
use App\Models\UnitInterest;
use App\Models\UnitService as ModelsUnitService;
use App\Notifications\Admin\NewTicketNotification;
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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\TicketTypeService;
use App\Services\Broker\TicketService;





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
    protected $ticketService;
    protected $ticketTypeService;





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
        DistrictService $districtService,
        TicketService $ticketService,
        TicketTypeService $ticketTypeService,

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
        $this->ticketService = $ticketService;
        $this->ticketTypeService =  $ticketTypeService;
    }



    public function index()
    {
        $finder = auth()->user();
        $roles = Role::all();
        $userRoles = $roles->filter(function ($role) use ($finder) {
            return $finder->hasRole($role->name);
        });


        if ($finder->is_renter == 1) {
            $finder->assignRole('Renter');
        } elseif ($finder->is_property_finder == 1) {
            $finder->assignRole('Property-Finder');
        }elseif ($finder->is_owner == 1) {
            $finder->assignRole('Owner');
            session(['active_role' => 'Owner']);

        }

        //favorites
        $favorites = FavoriteUnit::where('finder_id', $finder->id)->get();
        $units = Unit::with('Unitfavorites')
            ->whereIn('id', $favorites->pluck('unit_id'))
            ->get();
            $user = auth()->user();

        //requests
        $requests = RealEstateRequest::withCount(['requestStatuses as views_count' => function ($query) {
                $query->whereNotNull('read_by');
            }])->where('user_id', $user->id)->get();

            $count = 0;

        //tecnical support
        $tickets = $this->ticketService->getUserTickets(auth()->id());
        $ticketTypes = $this->ticketTypeService->getAllTicketTypes();
        $settings = Setting::first();
        $tickets->transform(function ($ticket) {
            $ticket->formatted_id = "100{$ticket->id}";
            $ticket->ticketResponses();
            return $ticket;
        });

        //

        if($finder->is_owner == 1 ){
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
            $city = $finder->UserOwnerData->CityData;
            $region = $city->RegionData ?? [];


        }

        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
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
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        'id_number' => [
            'required',
            'numeric',
            'digits:10',
            'unique:users,id_number,' . $id,
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
        'id_number.unique' => 'The ID number has already been taken.',
    ];

    $request->validate($rules, $messages);

    $finder = User::findOrFail($id);
    if ($request->hasFile('avatar')) {
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
    // If the user is marked as an owner, update or create their entry in the `owners` table
    if ($finder->is_owner) {
        Owner::where('user_id', $finder->id)->update([
            'name' => $finder->name,
            'email' => $finder->email,
            'phone' => $finder->phone,
            'key_phone' => $finder->key_phone,
            'full_phone' => $finder->full_phone,
            'city_id' => $request->city_id,
        ]);
    }


    return redirect()->route('PropertyFinder.home')->withSuccess(__('Property Finder updated successfully.'));
}


    // public function updatePropertyFinder(Request $request, $id)
    // {

    //     $rules = [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         'phone' => 'required|unique:users,phone,' . $id,
    //         'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    //         'id_number' => [
    //             'required',
    //             'numeric',
    //             'digits:10',
    //             'unique:users,id_number,' . $id, // Ensure ID number is unique, excluding the current user
    //             function ($attribute, $value, $fail) {
    //                 if (!preg_match('/^[12]\d{9}$/', $value)) {
    //                     $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
    //                 }
    //             },
    //         ],
    //     ];

    //     $messages = [
    //         'name.required' => __('The name field is required.'),
    //         'email.required' => __('The email field is required.'),
    //         'email.unique' => __('The email has already been taken.'),
    //         'phone.required' => __('The mobile field is required.'),
    //         'phone.unique' => __('The mobile has already been taken.'),
    //         'avatar.image' => __('The Image logo must be an image.'),
    //         'id_number.required' => 'The ID number field is required.',
    //         'id_number.numeric' => 'The ID number must be a number.',
    //         'id_number.digits' => 'The ID number must be exactly 10 digits long.',
    //         'id_number.unique' => 'The ID number has already been taken.', // Custom message for unique constraint
    //     ];

    //     $request->validate($rules, $messages);

    //     $finder = User::findOrFail($id);
    //     if ($request->hasFile('avatar')) {
    //         // Delete old avatar if it exists
    //         if ($finder->avatar) {
    //             $oldAvatarPath = public_path($finder->avatar);
    //             if (file_exists($oldAvatarPath)) {
    //                 unlink($oldAvatarPath);
    //             }
    //         }

    //         $file = $request->file('avatar');
    //         $ext = uniqid() . '.' . $file->clientExtension();
    //         $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
    //         $finder->avatar = '/PropertyFounder/' . 'Logos/' . $ext;
    //     }

    //         $finder->name = $request->name;
    //         $finder->email = $request->email;
    //         $finder->phone = $request->phone;
    //         $finder->id_number = $request->id_number;
    //         $finder->key_phone = $request->key_phone;
    //         $finder->full_phone = $request->key_phone . $request->phone;

    //         $finder->save();

    //     return redirect()->route('PropertyFinder.home')->withSuccess(__('Property Finder updated successfully.'));
    // }

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

public function GetDistrictsCity($id)
{
    $districts = District::where('city_id', $id)->get();
    // $districts = $this->districtService->getDistrictsByCity($id);
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

        return redirect()->route('PropertyFinder.home')->with('success', __('added successfully'));

    }

    public function editUnit($id)
    {
        // $Property = $this->PropertyService->findById($id);
        $Unit = Unit::where('owner_id', auth()->user()->UserOwnerData->id)
        ->where('id', $id)
        ->firstOrFail();
        $Unit = $this->UnitService->findById($id);
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $projects = $this->brokerDataService->getProjectsForOwners();
        $properties = $this->brokerDataService->getPropertiesForOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        $services = $this->AllServiceService->getAllServices();
        $features = $this->FeatureService->getAllFeature();
        return view('Home.Owners.Unit.edit', get_defined_vars());
    }

    public function updateUnit(Request $request, $id)
    {
        $rules = [
            'number_unit' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'price' => 'digits_between:0,10',
            'monthly' => 'digits_between:0,8',
            'instrument_number' => [
                'nullable',
                Rule::unique('units')->ignore($id),
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

        $unit = Unit::findOrFail($id);
        $data = $request->all();

        $unit_data = $data;
        unset($unit_data['name']);
        unset($unit_data['qty']);
        unset($unit_data['images']);
        unset($unit_data['service_id']);
        unset($unit_data['daily']);
        unset($unit_data['monthly']);
        unset($unit_data['quarterly']);
        unset($unit_data['midterm']);
        unset($unit_data['yearly']);

        $unit_data['show_gallery'] = 0;
        $unit_data['ad_license_status'] = 'InValid';

        if (isset($unit_data['daily_rent'])) {
            $unit_data['daily_rent'] = $unit_data['daily_rent'] == 'on' ? 1 : 0;
        } else {
            $unit_data['daily_rent'] = 0;
        }

        // Handle unit_masterplan upload
        if (isset($unit_data['unit_masterplan'])) {
            if (!empty($unit->unit_masterplan) && File::exists(public_path($unit->unit_masterplan))) {
                File::delete(public_path($unit->unit_masterplan));
            }
            $unitMasterplan = $unit_data['unit_masterplan'];
            $ext = $unitMasterplan->getClientOriginalExtension();
            $masterplanName = uniqid() . '.' . $ext;
            $unitMasterplan->move(public_path('/Brokers/Projects/Units/'), $masterplanName);
            $unit_data['unit_masterplan'] = '/Brokers/Projects/Units/' . $masterplanName;
        }

        // Handle video upload
        if (isset($unit_data['video'])) {
            if (!empty($unit->video) && File::exists(public_path($unit->video))) {
                File::delete(public_path($unit->video));
            }
            $video = $unit_data['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = uniqid() . '.' . $ext;
            $video->move(public_path('/Brokers/Projects/Unit/Video/'), $videoName);
            $unit_data['video'] = '/Brokers/Projects/Unit/Video/' . $videoName;
        }

        $unit->update($unit_data);

        // Update services
        if (isset($data['service_id'])) {
            $unit->unitServices()->delete();
            foreach ($data['service_id'] as $service) {
                ModelsUnitService::create(['unit_id' => $unit->id, 'service_id' => $service]);
            }
        }

        // Update rental prices
         UnitRentalPrice::updateOrCreate(['unit_id' => $unit->id], [
            'unit_id' => $unit->id,
            'daily' => $data['daily'],
            'monthly' => $data['monthly'],
            'quarterly' => $data['quarterly'],
            'midterm' => $data['midterm'],
            'yearly' => $data['yearly'],
        ]);

        // Update features
        if (isset($data['name'])) {
            $unit->UnitFeatureData()->delete();
            foreach ($data['name'] as $index => $Feature_name) {
                $Feature =    Feature::where('name', $Feature_name)->first();
                if (!$Feature) {
                    $Feature =   Feature::create(['name' => $Feature_name, 'created_by' => Auth::id()]);
                }
                UnitFeature::create(['feature_id' => $Feature->id, 'unit_id' => $unit->id, 'qty' => $data['qty'][$index]]);
            }
        }

        // Handle images
        if (isset($data['images'])) {
            $unit->unitImages()->delete();
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

        return redirect()->route('PropertyFinder.home')->with('success', __('updated successfully'));
    }

    public function deleteUnit($id)
    {
        $unit=Unit::destroy($id);
        return redirect()->route('PropertyFinder.home')->with('success', __('Deleted successfully'));

    }


    public function GetCitiesRegion($id)
    {
        // $cities = City::where('region_id', $id)->get();
        $cities =City::where('region_id', $id)->get();

        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }

    public function createProperty()
    {
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $services = $this->ServiceTypeService->getAllServiceTypes();
        return view('Home.Owners.Property.create', get_defined_vars());
    }

    public function storeProperty(Request $request)
{
    // Define validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'service_type_id' => 'required|exists:service_types,id',
        'is_divided' => 'required|boolean',
        'city_id' => 'required|exists:cities,id',
        'owner_id' => 'required|exists:owners,id',
        'instrument_number' => [
            'nullable',
            Rule::unique('properties'),
            'max:25'
        ],
        'property_masterplan' => 'nullable|file|mimes:pdf|max:2048',
        'property_brochure' => 'nullable|file|mimes:pdf|max:2048',
        'ad_license_number' => 'nullable|numeric|unique:properties,ad_license_number',
        'ad_license_expiry' => 'nullable|date|after_or_equal:today',
    ];

    // Define validation messages
    $messages = [
        'name.required' => __('The :attribute field is required.', ['attribute' => __('name')]),
        'name.string' => __('The :attribute must be a string.', ['attribute' => __('name')]),
        'name.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('name'), 'max' => 255]),
        'location.required' => __('The :attribute field is required.', ['attribute' => __('location')]),
        'location.string' => __('The :attribute must be a string.', ['attribute' => __('location')]),
        'location.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('location'), 'max' => 255]),
        'service_type_id.required' => __('The :attribute field is required.', ['attribute' => __('service type')]),
        'service_type_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('service type')]),
        'is_divided.required' => __('The :attribute field is required.', ['attribute' => __('is divided')]),
        'is_divided.boolean' => __('The :attribute field must be true or false.', ['attribute' => __('is divided')]),
        'city_id.required' => __('The :attribute field is required.', ['attribute' => __('city')]),
        'city_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('city')]),
        'owner_id.required' => __('The :attribute field is required.', ['attribute' => __('owner')]),
        'owner_id.exists' => __('The selected :attribute is invalid.', ['attribute' => __('owner')]),
        'instrument_number.unique' => __('The :attribute has already been taken.', ['attribute' => __('instrument number')]),
        'instrument_number.max' => __('The :attribute may not be greater than :max characters.', ['attribute' => __('instrument number'), 'max' => 25]),
        'property_masterplan.file' => __('The master plan must be a file.'),
        'property_masterplan.mimes' => __('The master plan must be a PDF file.'),
        'property_masterplan.max' => __('The master plan may not be greater than :max kilobytes.', ['max' => 2048]),
        'property_brochure.file' => __('The brochure must be a file.'),
        'property_brochure.mimes' => __('The brochure must be a PDF file.'),
        'property_brochure.max' => __('The brochure may not be greater than :max kilobytes.', ['max' => 2048]),
        'ad_license_number.unique' => __('The license number has already been taken.'),
        'ad_license_number.numeric' => 'The license number must be a number.',
        'ad_license_expiry.date' => 'The license expiry date is not a valid date.',
        'ad_license_expiry.after_or_equal' => 'The license expiry date must be today or a future date.',
    ];

    // Validate request data
    $request->validate($rules, $messages);

    $property_data = $request->all();

    unset($property_data['images']);
    // Handle project_masterplan upload
    if ($request->hasFile('property_masterplan')) {
        $propertyMasterplan = $request->file('property_masterplan');
        $ext = $propertyMasterplan->getClientOriginalExtension();
        $masterplanName = uniqid() . '.' . $ext;
        $propertyMasterplan->move(public_path('/Brokers/Properties/pdfs'), $masterplanName);
        $property_data['property_masterplan'] = '/Brokers/Properties/pdfs/' . $masterplanName;
    }

    // Handle project_brochure upload
    if ($request->hasFile('property_brochure')) {
        $propertyBrochure = $request->file('property_brochure');
        $ext = $propertyBrochure->getClientOriginalExtension();
        $brochureName = uniqid() . '.' . $ext;
        $propertyBrochure->move(public_path('/Brokers/Properties/pdfs'), $brochureName);
        $property_data['property_brochure'] = '/Brokers/Properties/pdfs/' . $brochureName;
    }


    // Handle ad_license_number and ad_license_expiry validation if show_in_gallery is set

        $property_data['show_in_gallery'] = 0;
        $property_data['ad_license_status'] = 'InValid';


    // Create the property
    $property = Property::create($property_data);

    // Handle property images if provided
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $ext = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/Brokers/Projects/Property/'), $ext);
            PropertyImage::create([
                'image' => '/Brokers/Projects/Property/' . $ext,
                'property_id' => $property->id,
            ]);
        }
    }

    return redirect()->route('PropertyFinder.home')->with('success', __('added successfully'));
}


    public function editProperty($id)
    {
        // $Property = $this->PropertyService->findById($id);
        $Property = Property::where('owner_id', auth()->user()->UserOwnerData->id)
        ->where('id', $id)
        ->firstOrFail();
        $types = $this->propertyTypeService->getAllPropertyTypes();
        $usages =  $this->propertyUsageService->getAllPropertyUsages();
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        // $owners = $this->brokerDataService->getOwners();
        $servicesTypes = $this->ServiceTypeService->getAllServiceTypes();
        return view('Home.Owners.Property.edit', get_defined_vars());
    }

    public function updateProperty(Request $request, $id)
    {
        $rules = [];
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'service_type_id' => 'required|exists:service_types,id',
            // 'is_divided' => 'required|boolean',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:owners,id',
            'instrument_number' => [
                'nullable',
                Rule::unique('properties')->ignore($id),
                'max:25'
            ],
        ];
        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than :max characters.',
            'service_type_id.required' => 'The service type ID field is required.',
            'service_type_id.exists' => 'The selected service type ID is invalid.',
            'city_id.required' => 'The city ID field is required.',
            'city_id.exists' => 'The selected city ID is invalid.',
            'owner_id.required' => 'The owner ID field is required.',
            'owner_id.exists' => 'The selected owner ID is invalid.',
            'instrument_number.unique' => 'The instrument number has already been taken.',
            'instrument_number.max' => 'The instrument number may not be greater than :max characters.',
        ];

        $request->validate($rules, $messages);

        $property = Property::findOrFail($id);
        $property_data = $request->all();
        unset($property_data['images']);


        // Handle project_masterplan upload
        if ($request->hasFile('property_masterplan')) {
            if (!empty($property->property_masterplan) && File::exists(public_path($property->property_masterplan))) {
                File::delete(public_path($property->property_masterplan));
            }
          $propertyMasterplan = $property_data['property_masterplan'];
          $ext = $propertyMasterplan->getClientOriginalExtension();
          $masterplanName = uniqid() . '.' . $ext;
          $propertyMasterplan->move(public_path('/Brokers/Properties/pdfs'), $masterplanName);
          $property_data['property_masterplan'] = '/Brokers/Properties/pdfs/' . $masterplanName;
      }

      // Handle project_brochure upload
      if ($request->hasFile('property_brochure')) {
        if (!empty($property->property_brochure) && File::exists(public_path($property->property_brochure))) {
            File::delete(public_path($property->property_brochure));
        }
          $propertyBrochure = $property_data['property_brochure'];
          $ext = $propertyBrochure->getClientOriginalExtension();
          $brochureName = uniqid() . '.' . $ext;
          $propertyBrochure->move(public_path('/Brokers/Properties/pdfs'), $brochureName);
          $property_data['property_brochure'] = '/Brokers/Properties/pdfs/' . $brochureName;
      }


        $property_data['show_in_gallery'] = 0;
        $property_data['ad_license_status'] ='InValid';


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $property->PropertyImages()->delete();
                $ext = uniqid() . '.' . $image->clientExtension();
                $image->move(public_path() . '/Brokers/Projects/Property/', $ext);
                PropertyImage::create([
                    'image' => '/Brokers/Projects/Property/' . $ext,
                    'property_id' => $property->id,
                ]);
            }
        };
        $property->update($property_data);

        return redirect()->route('PropertyFinder.home')->with('success', __('updated successfully'));

    }

    public function deleteProperty($id)
    {
        $Property=Property::destroy($id);
        return redirect()->route('PropertyFinder.home')->with('success', __('Deleted successfully'));

    }


    public function createTicket(Request $request)
    {

        $validatedData = $request->validate([
            'type' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ], [
            'type.required' => 'The type field is required.',
            'subject.required' => 'The subject field is required.',
            'content.required' => 'The content field is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Only JPEG, PNG, JPG, and GIF formats are allowed for the image.',
            'image.max' => 'The image size must not exceed 2048 kilobytes.',
        ]);
        // Handle file upload if an image is provided

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path('Owners/Tickets'), $fileName);
            $validatedData['image'] = '/Owners/Tickets/' . $fileName;
        }

        $ticket = new Ticket();
        $user_id = auth()->user()->id;
        $ticket->user_id = $user_id;

        $ticket->subject = $validatedData['subject'];
        $ticket->content = $validatedData['content'];
        $ticket->image = $validatedData['image'] ?? null; // If no image provided, set to null
        $ticket->ticket_type_id = $validatedData['type'];
        $ticket->unit_id = $request['unit_id'] ?? null;
        $ticket->project_id = $request['project_id'] ?? null;
        $ticket->property_id = $request['property_id'] ?? null;

        $ticket->save();
        $this->notifyAdmins($ticket);

        return redirect()->route('PropertyFinder.home')->with('success', 'Ticket created successfully');

    }
    protected function notifyAdmins(Ticket $ticket)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewTicketNotification($ticket));
        }
    }

    public function addReplay(Request $request, $ticketId)
    {
        $request->validate([
            'response' => 'required|string',
            'response_attachment' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'response.required' => 'The response field is required.',
            'response.string' => 'The response must be a string.',
            'response_attachment.mimes' => 'The response attachment must be a valid image (jpg, jpeg, png, gif) or PDF file.',
            'response_attachment.max' => 'The response attachment may not be greater than :max kilobytes.',
        ]);
        $ticketData = [
            'user_id' => auth()->user()->id,
            'response' => $request->input('response'),
            'response_attachment' => $request->file('response_attachment'),
        ];

        $this->ticketService->addResponseToTicket($ticketId, $ticketData);

        return redirect()->back()->with('success', __('Replay added successfully'));
    }


}
