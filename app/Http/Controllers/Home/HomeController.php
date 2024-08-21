<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Traits\Email\MailWelcomeBroker;
use App\Models\Gallery;
use App\Notifications\Admin\NewBrokerNotification;
use App\Notifications\Admin\NewOfficeNotification;
use App\Notifications\Admin\NewTicketNotification;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Office;
use App\Models\Region;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Broker;
use App\Models\ContactUs;
use App\Models\InterestType;
use App\Models\PartnerSuccess;
use App\Models\RealEstateRequest;
use App\Models\RequestStatus;
use App\Models\Setting;
use App\Models\SystemInvoice;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionTypeRole;
use App\Models\Unit;
use App\Notifications\Admin\NewContactUsNotification;
use App\Notifications\Admin\NewPropertyFinderNotification;
use App\Notifications\Admin\NewRealEstateRequestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Admin\SectionService;
use App\Services\CityService;
use App\Services\PropertyTypeService;
use App\Services\Admin\DistrictService;
use App\Http\Traits\Email\MailSendCode;
use App\Models\Advertising;
use App\Models\Ticket;
use App\Services\NafathService;


class HomeController extends Controller
{
    use MailWelcomeBroker;

    use MailSendCode;


    protected $subscriptionTypeService;
    protected $SectionService;
    protected $cityService;
    protected $propertyTypeService;
    protected $districtService;

    protected $nafathService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService
    , SectionService $SectionService,
    CityService $cityService,
    PropertyTypeService $propertyTypeService,
    DistrictService $districtService,
    NafathService $nafathService
    )
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
        $this->SectionService = $SectionService;
        $this->cityService = $cityService;
        $this->propertyTypeService = $propertyTypeService;
        $this->districtService = $districtService;
        $this->nafathService = $nafathService;


    }



    public function index()
    {
        //subscrptions
        // $subscriptionTypes = $this->subscriptionTypeService->getAll()
        //     ->where('is_deleted', 0)
        //     ->where('is_show', 1)
        //     ->where('status', 1);
        $subscriptionTypes = SubscriptionType::where('is_deleted', 0)
        ->where('is_show', 1)
        ->where('status', 1)
        ->whereHas('roles', function ($query) {
            $query->where('type', 'user');
        })
        ->with('sections') // Eager load sections relationship
        ->get();
        $sections = $this->SectionService->getAll();
        ////
        $RolesIds = Role::whereIn('name', ['RS-Broker'])->pluck('id')->toArray();
        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
        $subscriptionTypesRoles = $this->subscriptionTypeService->getAll()
            ->where('is_deleted', 0)->where('is_show', 1)->where('status', 1)
            ->whereIn('id', $RolesSubscriptionTypeIds);

        ///
        $sitting =   Setting::first();
        $partnerSuccesses = PartnerSuccess::all();
        $cities = $this->cityService->getAllCities();
        $types = $this->propertyTypeService->getAllPropertyTypes();
        if ($sitting->active_home_page == 1) {
            return view('Home.home', get_defined_vars());
        } else {
            return redirect()->route('Admin.home', get_defined_vars());
        }
    }

    // public function sendOtp(Request $request)
    // {
    //     $email = $request->input('user_name');

    //         $otp = mt_rand(100000, 999999);
    //         session(['otp' => $otp, 'email' => $email]);
    //         $this->MailSendCode($request->user_name, $otp);
    //         return redirect()->route('Home.auth.verifyLogin')->with('success', __('OTP sent successfully'));

    // }

    public function sendOtp(Request $request)
    {

        // $otp = mt_rand(100000, 999999);
        $otp=555555;
        session()->forget(['otp', 'email', 'phone', 'mobile', 'key_phone']);

        session(['otp' => $otp]);

        if ($request->input('otp_type') === 'email') {
            $email = $request->input('user_name');
            session(['email' => $email]);
            $this->MailSendCode($email, $otp);
        } else if ($request->input('otp_type') === 'phone') {
            $fullPhone = $request->input('full_phone');
            $phone = $request->input('mobile');
            $keyPhone = $request->input('key_phone');

            session(['phone' => $fullPhone, 'mobile' => $phone, 'key_phone' => $keyPhone]);
            // $this->SmsSendCode($fullPhone, $otp);
        }

        return redirect()->route('Home.auth.verifyLogin')->with('success', __('OTP sent successfully'));
    }


    public function loginByPassword()
    {
        $email = session('email');

        return view('auth.loginByPassword', get_defined_vars());
    }

    public function verifyLogin()
    {
        $email = session('email');
        $fullPhone = session('phone');
        $KeyPhone = session('Key_phone');



        return view('auth.verifyLogin', get_defined_vars());
    }

    public function chooseAccount()
    {

        return view('auth.verifyLogin');
    }


    public function showRegion($id)
    {
        $region = Region::findOrFail($id);
        $cities = $region->cities;
        return response()->json($cities);
    }



    public function createBroker()
    {
        $email = session('email');
        $fullPhone = session('phone');
        $phone = session('mobile');
        $KeyPhone = session('key_phone');

        $setting =   Setting::first();
        if ($setting->active_broker == 0) {
            return back()->with('sorry', __('Soon'));
        }

        $termsAndConditionsUrl = $setting->terms_pdf;
        $privacyPolicyUrl = $setting->privacy_pdf;
        $Regions = Region::all();
        $cities = City::all();
        $RolesIds = Role::whereIn('name', ['RS-Broker'])->pluck('id')->toArray();

        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();

        $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
            ->whereIn('id', $RolesSubscriptionTypeIds)
            ->get();
        return view('Home.Auth.broker.create', get_defined_vars());
    }
    public function createOffice()
    {
        $email = session('email');
        $fullPhone = session('phone');
        $phone = session('mobile');
        $KeyPhone = session('Key_phone');


        $setting =   Setting::first();
        if ($setting->active_office == 0) {
            return back()->with('sorry', __('Soon'));
        }
        $termsAndConditionsUrl = $setting->terms_pdf;
        $privacyPolicyUrl = $setting->privacy_pdf;
        $Regions = Region::all();
        $cities = City::all();
        $RolesIds = Role::whereIn('name', ['Office-Admin'])->pluck('id')->toArray();

        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();

        // $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('is_show', 1)->where('status', 1)->whereIn('id', $RolesSubscriptionTypeIds)->get();

        $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
            ->whereIn('id', $RolesSubscriptionTypeIds)
            ->get();
        return view('Home.Auth.office.create', get_defined_vars());
    }


    public function storeOffice(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'city_id' => 'required|exists:cities,id',
            'company_logo' => 'file',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'CRN' => [
                'required',
                Rule::unique('offices'),
                'max:25'
            ],
            'phone' => [
                'required',
                'max:25'
            ],
            'full_phone' => [
                'required',
                Rule::unique('users'),
                'max:25'
            ],
            // 'presenter_name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
        $messages = [
            'name.required' => __('The company name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.unique' => __('The email has already been taken.'),
            'email.max' => __('The email may not be greater than :max characters.'),
            'city_id.required' => __('The city field is required.'),
            'city_id.exists' => __('The selected city is invalid.'),
            'company_logo.required' => __('The company logo field is required.'),
            'company_logo.file' => __('The company logo must be a file.'),
            'subscription_type_id.required' => __('The subscription type field is required.'),
            'subscription_type_id.exists' => __('The selected subscription type is invalid.'),
            'CRN.required' => __('The CRN field is required.'),
            'CRN.unique' => __('The CRN has already been taken.'),
            'CRN.max' => __('The CRN may not be greater than :max characters.'),
            'phone.required' => __('The Company mobile number field is required.'),
            'full_phone.unique' => __('The Company mobile number has already been taken.'),
            'phone.max' => __('The Company mobile number may not be greater than :max characters.'),
            'presenter_name.required' => __('The presenter name field is required.'),
            'presenter_name.string' => __('The presenter name must be a string.'),
            'presenter_name.max' => __('The presenter name may not be greater than :max characters.'),
            'password.required' => __('The password field is required.'),
            'password.string' => __('The password must be a string.'),
            'password.max' => __('The password may not be greater than :max characters.'),
        ];
        $request->validate($rules, $messages);
        $request_data = [];

        if ($request->company_logo) {
            $file = $request->File('company_logo');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Offices/' . 'Logos/', $ext);
            $request_data['company_logo'] = '/Offices/' . 'Logos/' . $ext;
        }
        // $Last_customer_id = User::latest()->value('customer_id');
        // if (!$Last_customer_id) {
        //     $new_customer_id = str_pad(1 + 1, 4, '0', STR_PAD_LEFT);
        // } else {
        //     $new_customer_id = str_pad($Last_customer_id + 1, 4, '0', STR_PAD_LEFT);
        // }

        $Last_customer_id = User::where('customer_id', '!=', null)->latest()->value('customer_id');
        $delimiter = '-';
        $prefixes = ['AMK1-', 'AMK2-', 'AMK3-', 'AMK4-', 'AMK5-', 'AMK6-'];
        if (!$Last_customer_id) {
            $new_customer_id = 'AMK1-0001';
        } else {
            $result = explode($delimiter, $Last_customer_id);
            $number = (int)$result[1] + 1;
            $tag_index = min(intval($number / 1000), count($prefixes) - 1);
            $tag = $prefixes[$tag_index];
            $new_customer_id = $tag . str_pad($number % 1000, 4, '0', STR_PAD_LEFT);
        }

        $user = User::create([
            'is_office' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'customer_id' => $new_customer_id,
            'avatar' => $request_data['company_logo'] ?? null,
        ]);

        $office = Office::create([
            'user_id' => $user->id,
            'CRN' => $request->CRN,
            'company_name' => $user->name,
            'city_id' => $request->city_id,
            'created_by' => Auth::id(),
            // 'presenter_name' => $request->presenter_name,
            'company_logo' => $request_data['company_logo'] ?? null,
        ]);
        $subscriptionType = SubscriptionType::find($request->subscription_type_id); // Or however you obtain your instance
        $startDate = Carbon::now();
        $endDate = $subscriptionType->calculateEndDate($startDate)->format('Y-m-d H:i:s');
        if ($subscriptionType->price > 0) {
            $SubType = 'paid';
            $status = 'pending';
        } else {
            $SubType = 'free';
            $status = 'active';
        }
        $subscription = Subscription::create([
            'office_id' => $office->id,
            'subscription_type_id' => $request->subscription_type_id,
            'status' => $status,
            'is_start' => $status == 'pending' ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => $endDate,
            'total' => '200'
        ]);
        $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');

        $delimiter = '-';
        if (!$Last_invoice_ID) {
            $new_invoice_ID = '00001';
        } else {
            $result = explode($delimiter, $Last_invoice_ID);
            $number = (int)$result[1] + 1;
            $new_invoice_ID = str_pad($number % 10000, 5, '0', STR_PAD_LEFT);
        }
        $Invoice = SystemInvoice::create([
            'office_id' => $office->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $SubType,
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ]);
        $galleryName = explode('@', $request->email)[0];
        $defaultCoverImage = '/Gallery/cover/cover.png';


        //
        $hasRealEstateGallerySection = $subscriptionType->sections()->get();

        $sectionNames = [];
        foreach ($hasRealEstateGallerySection as $section) {
            $sectionNames[] = $section->name;
        }

        if (in_array('Realestate-gallery', $sectionNames) || in_array('المعرض العقاري', $sectionNames)) {
            $galleryName = explode('@', $request->email)[0];
            $defaultCoverImage = '/Gallery/cover/cover.png';

            $gallery = Gallery::create([
                'office_id' => $office->id,
                'gallery_name' => $galleryName,
                'gallery_status' => 1,
                'gallery_cover' => $defaultCoverImage,
            ]);
        } else {
            $gallery = null;
        }
        $this->notifyAdminsForOffice($office);

        $this->MailWelcomeBroker($user, $subscription, $subscriptionType, $Invoice);
        auth()->loginUsingId($user->id);

        return redirect()->route('login')->with('success', __('registerd successfully'));
    }


    public function storeBroker(Request $request)
    {

        // return $request;
        // $validationResponse = $this->nafathService->validateId($request->input('id_number'));
        // // dd($validationResponse);

        // if ($validationResponse['status'] != 'success') {
        //     return redirect()->back()->withErrors(['id_number' => 'Invalid ID number'])->withInput();
        // }


        // $nafathResponse = $this->nafathService->validateId($request->input('id_number'));
        // if (!$nafathResponse || !isset($nafathResponse['valid']) || !$nafathResponse['valid']) {
        //     return redirect()->back()->with('success', 'Invalid ID number. Registration failed.');
        // }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'full_phone' => 'required|unique:brokers,full_phone',
            // 'city_id' => 'required|exists:cities,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'license_number' => 'required|numeric|unique:brokers,broker_license',
            'password' => 'required|string|max:255|confirmed',
            'broker_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            // 'id_number' => 'nullable|unique:brokers,id_number'

        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'full_phone.required' => __('The mobile field is required.'),
            'full_phone.unique' => __('The mobile has already been taken.'),
            'full_phone.digits' => __('The mobile must be 9 digits.'),
            // 'city_id.required' => __('The city field is required.'),
            // 'city_id.exists' => __('The selected city is invalid.'),
            'subscription_type_id.required' => __('The subscription type field is required.'),
            'subscription_type_id.exists' => __('The selected subscription type is invalid.'),
            'license_number.required' => __('The license number field is required.'),
            'license_number.unique' => __('The license number has already been taken.'),
            'license_number.numeric' => __('The license number must be a number.'),
            'password.required' => __('The password field is required.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'broker_logo.image' => __('The broker logo must be an image.'),
            // 'id_number.unique' => __('The ID number has already been taken.')
        ];


        $request->validate($rules, $messages);

        $request_data = [];

        if ($request->hasFile('broker_logo')) {
            $file = $request->file('broker_logo');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Brokers/' . 'Logos/', $ext);
            $request_data['broker_logo'] = '/Brokers/' . 'Logos/' . $ext;
        }


        $Last_customer_id = User::where('customer_id', '!=', null)->latest()->value('customer_id');

        $delimiter = '-';
        $prefixes = ['AMK1-', 'AMK2-', 'AMK3-', 'AMK4-', 'AMK5-', 'AMK6-'];

        if (!$Last_customer_id) {
            $new_customer_id = 'AMK1-0001';
        } else {
            $result = explode($delimiter, $Last_customer_id);
            $number = (int)$result[1] + 1;
            $tag_index = min(intval($number / 1000), count($prefixes) - 1);
            $tag = $prefixes[$tag_index];
            $new_customer_id = $tag . str_pad($number % 1000, 4, '0', STR_PAD_LEFT);
        }


        $user = User::create([
            'is_broker' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'phone' => $request->mobile,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'customer_id' => $new_customer_id,
            'avatar' => $request_data['broker_logo'] ?? null,
        ]);

        // Create Broker
        $broker = Broker::create([
            'user_id' => $user->id,
            'broker_license' => $request->license_number,
            'license_date' => $request->license_date,
            'mobile' => $request->mobile,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'city_id' => $request->city_id,
            'broker_logo' => $request_data['broker_logo'] ?? 'HOME_PAGE/img/avatars/14.png',
        ]);




        $subscriptionType = SubscriptionType::find($request->subscription_type_id);
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
            'broker_id' => $broker->id,
            'subscription_type_id' => $request->subscription_type_id,
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
            'broker_id' => $broker->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $SubType,
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ]);

        $galleryName = explode('@', $request->email)[0];
        $defaultCoverImage = '/Gallery/cover/cover.png';


        //
        $hasRealEstateGallerySection = $subscriptionType->sections()->get();

        $sectionNames = [];
        foreach ($hasRealEstateGallerySection as $section) {
            $sectionNames[] = $section->name;
        }

        if (in_array('Realestate-gallery', $sectionNames) || in_array('المعرض العقاري', $sectionNames)) {
            // Create the gallery
            $galleryName = explode('@', $request->email)[0];
            $defaultCoverImage = '/Gallery/cover/cover.png';
            $gallery = Gallery::create([
                'broker_id' => $broker->id,
                'gallery_name' => $galleryName,
                'gallery_status' => 1,
                'gallery_cover' => $defaultCoverImage,
            ]);
        } else {
            $gallery = null;
        }

        if ($broker->license_date > now()->format('Y-m-d')) {
            $broker->update(['license_validity' => 'valid']);
            // Gallery::where('broker_id', $broker->id)->first()->update(['gallery_status' => '1']);
        } else {
            $broker->update(['license_validity' => 'expired']);
            $checkGallery =     Gallery::where('broker_id', $broker->id)->first();
            if ($checkGallery) {
                $checkGallery->update(['gallery_status' => '0']);
            }
        }

        $this->notifyAdmins($broker);

        $this->MailWelcomeBroker($user, $subscription, $subscriptionType, $Invoice);

        auth()->loginUsingId($user->id);
        return redirect()->route('Broker.home')->withSuccess(__('registerd successfully'));

        // return redirect()->route('login')->with('success', __('registerd successfully'));
    }

    protected function notifyAdmins(Broker $broker)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewBrokerNotification($broker));
        }
    }

    protected function notifyAdminsForOffice(Office $office)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewOfficeNotification($office));
        }
    }


    public function UpdateToken(Request $request)
    {
        $user = User::find(Auth::id());
        $user->update(['fcm_token' => $request->token]);
    }

    public function showAllBrokers(Request $request)
    {

        $users =  User::where('is_broker', true)
            ->whereHas('UserBrokerData.GalleryData')
            ->with('UserBrokerData')
            ->whereHas('UserBrokerData', function ($query) {
                $query->where('license_validity', 'valid');
            })
            ->paginate(9);

        foreach ($users as $key => $user) {
            $broker =  $user->UserBrokerData;
            if ($broker->license_date > now()->format('Y-m-d')) {
                $broker->update(['license_validity' => 'valid']);
            } else {
                $broker->update(['license_validity' => 'expired']);
                $check_gallary = Gallery::where('broker_id', $broker->id)->first();
                if ($check_gallary) {
                    $check_gallary->update(['gallery_status' => '0']);
                }
            }
        }
        $advertisings = Advertising::where('status', 'Published')->get();


        return view('Home.Brokers.index', get_defined_vars());
    }

    public function loadMoreBrokers(Request $request)
    {
        $brokers = User::where('is_broker', 1)->paginate(3);
        return view('Home.Brokers.inc._brokers', compact('brokers'));
    }


    public function createPropertyFinder()
    {
        $email = session('email');

        $setting =   Setting::first();

        $termsAndConditionsUrl = $setting->terms_pdf;
        $privacyPolicyUrl = $setting->privacy_pdf;
        $Regions = Region::all();
        $cities = City::all();
        $RolesIds = Role::whereIn('name', ['Property-Finder'])->pluck('id')->toArray();

        return view('Home.Auth.propertyFinder.create', get_defined_vars());
    }



    public function storePropertyFinder(Request $request)
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
            // 'full_phone.required' => __('The mobile field is required.'),
            // 'full_phone.unique' => __('The mobile has already been taken.'),
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
            // 'phone' => $request->phone,
            // 'key_phone' => $request->key_phone,
            // 'full_phone' => $request->full_phone,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'avatar' => $request_data['avatar'] ?? null,
        ]);

        $this->notifyAdmins2($user);
        auth()->loginUsingId($user->id);

        return redirect()->route('login')->withSuccess(__('Property Finder created successfully.'));
    }

    protected function notifyAdmins2(User $user)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewPropertyFinderNotification($user));
        }
    }

    function StoreContactUs(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'full_phone' => 'required|string|max:255',
            'message' => 'required|string',
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'full_phone.required' => __('The mobile field is required.'),
            'message.required' => __('The message field is required.'),
        ];
        $request->validate($rules, $messages);
        $ContactUs =   ContactUs::create($request->all());
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewContactUsNotification($ContactUs));
        }

        return back()->withSuccess(__('Your message has been received successfully'));
    }

    function Privacy()
    {
        $setting = Setting::first();
        return view('Home.Privacy', get_defined_vars());
    }

    function Terms()
    {
        $setting = Setting::first();
        return view('Home.Terms', get_defined_vars());
    }
    public function createRequest(Request $request)
    {

        $request->validate([
            'property_type_id' => 'required|exists:property_types,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'nullable|exists:districts,id',
            'ad_type' => 'nullable|string',
            'area' => 'nullable|integer',
            'rooms' => 'nullable|integer',
            'description' => 'nullable|string',
            // 'request_valid' => 'required|in:active,canceled',
        ]);

        $lastRequest = RealEstateRequest::where('number_of_requests', 'LIKE', 'RS-%')
            ->latest('created_at')
            ->first();

        $prefix = 'RS-';
        $delimiter = '-';
        $startNumber = 1;

        if ($lastRequest) {
            $lastNumber = explode($delimiter, $lastRequest->number_of_requests)[1];
            $startNumber = (int)$lastNumber + 1;
        }

        $numberOfRequests = $prefix . str_pad($startNumber, 4, '0', STR_PAD_LEFT);
        $realEstateRequest = RealEstateRequest::create([
            'number_of_requests' => $numberOfRequests,
            'user_id' => Auth::id(),
            'property_type_id' => $request->input('property_type_id'),
            'city_id' => $request->input('city_id'),
            'district_id' => $request->input('district_id'),
            'ad_type' => $request->input('ad_type'),
            'area' => $request->input('area'),
            'rooms' => $request->input('rooms'),
            'description' => $request->input('description'),
            // 'request_valid' => $request->input('request_valid'),
        ]);
        $this->notifyAllBrokers($realEstateRequest);

        return redirect()->back()->with('success', 'added successfully');

    }
    protected function notifyAllBrokers(RealEstateRequest $realEstateRequest)
{
    $cityId = $realEstateRequest->city_id;

    // Find users who are brokers or belong to an office in the same city as the request
    $users = User::where(function($query) use ($cityId) {
        $query->whereHas('UserBrokerData', function ($q) use ($cityId) {
            $q->where('city_id', $cityId);
        })->orWhereHas('UserOfficeData', function ($q) use ($cityId) {
            $q->where('city_id', $cityId);
        });
    })->get();

    // Notify each user
    foreach ($users as $user) {
        Notification::send($user, new NewRealEstateRequestNotification($realEstateRequest));

        $defaultInterestType = InterestType::where('default', 1)->first();

        if ($defaultInterestType) {
            RequestStatus::create([
                'user_id' => $user->id,
                'request_id' => $realEstateRequest->id,
                'request_status_id' => $defaultInterestType->id
            ]);
        } else {
            return redirect()->back()->withErrors(['default' => __('No default interest type found.')]);
        }
    }
}

//     protected function notifyAllBrokers(RealEstateRequest $realEstateRequest)
// {
//     $users = User::where('is_broker', true)
//     ->orWhere('is_office', true)
//     ->get();
//     foreach ($users as $user) {
//         Notification::send($user, new NewRealEstateRequestNotification($realEstateRequest));
//         $defaultInterestType = InterestType::where('default', 1)->first();

//         if ($defaultInterestType) {
//             RequestStatus::create([
//                 'user_id' => $user->id,
//                 'request_id' => $realEstateRequest->id,
//                 'request_status_id' => $defaultInterestType->id
//             ]);
//         } else {
//             return redirect()->back()->withErrors(['default' => __('No default interest type found.')]);
//         }

//     }
//     }
    public function GetDistrictsByCity($id)
    {
        $districts = $this->districtService->getDistrictsByCity($id);

        return view('Admin.settings.Region.inc._district', get_defined_vars());
    }

    public function sendAdReport(Request $request)
    {
        //
        // Validate the form data
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
            $file->move(public_path('Brokers/Tickets'), $fileName);
            $validatedData['image'] = '/Brokers/Tickets/' . $fileName;
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
        $ticket->ad_url = $request['ad_url'] ?? null;


        $ticket->save();
        $this->notifyAdmins3($ticket);

        return redirect()->back()->with('success', 'Ad report send successfully');
    }

    protected function notifyAdmins3(Ticket $ticket)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewTicketNotification($ticket));
        }
    }


}
