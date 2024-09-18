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
use App\Models\Owner;
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

        // $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
        //     ->whereIn('id', $RolesSubscriptionTypeIds)
        //     ->get();
        $subscriptionType = SubscriptionType::where('is_deleted', 0)
        ->where('status', 1)
        ->where('new_subscriber', '1')
        ->whereIn('id', $RolesSubscriptionTypeIds)
        ->first();

        return view('Home.Auth.broker.create', get_defined_vars());
    }

    public function createNewBroker()
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

        // $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
        //     ->whereIn('id', $RolesSubscriptionTypeIds)
        //     ->get();
        $subscriptionType = SubscriptionType::where('is_deleted', 0)
        ->where('status', 1)
        ->where('new_subscriber', '1')
        ->whereIn('id', $RolesSubscriptionTypeIds)
        ->first();
        $newBroker=auth()->user();
        return view('Home.Auth.broker.CreateBroker', get_defined_vars());
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

        // $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
        //     ->whereIn('id', $RolesSubscriptionTypeIds)
        //     ->get();

        $subscriptionType = SubscriptionType::where('is_deleted', 0)
        ->where('status', 1)
        ->where('new_subscriber', '1')
        ->whereIn('id', $RolesSubscriptionTypeIds)
        ->first();
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
            // 'id_number' => $request->id_number,

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
    public function createNewOffice()
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

        // $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
        //     ->whereIn('id', $RolesSubscriptionTypeIds)
        //     ->get();

        $subscriptionType = SubscriptionType::where('is_deleted', 0)
        ->where('status', 1)
        ->where('new_subscriber', '1')
        ->whereIn('id', $RolesSubscriptionTypeIds)
        ->first();
            $newOffice=auth()->user();
        return view('Home.Auth.office.CreateOffice', get_defined_vars());
    }


    public function storeNewOffice(Request $request)
    {


        $rules = [
            'city_id' => 'required|exists:cities,id',
            'company_logo' => 'file',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'CRN' => [
                'required',
                Rule::unique('offices'),
                'max:25'
            ],
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



    // Check if the user already exists with incomplete data
    $user = User::where('email', $request->email)->first();

    $request_data = [];
    if ($request->company_logo) {
        $file = $request->File('company_logo');
        $ext  =  uniqid() . '.' . $file->clientExtension();
        $file->move(public_path() . '/Offices/' . 'Logos/', $ext);
        $request_data['company_logo'] = '/Offices/' . 'Logos/' . $ext;
    }

    if ($user) {
        // Update existing user
        $user->update([
            'is_office' => 1,
            'customer_id' => $this->generateCustomerId(),
            'avatar' => $request_data['company_logo'] ?? null,
        ]);
    }else{
        $user = User::create([
            'is_office' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'customer_id' => $this->generateCustomerId(),
            'avatar' => $request_data['company_logo'] ?? null,
            // 'id_number' => $request->id_number,

        ]);

    }


        $office = Office::create([
            'user_id' => $user->id,
            'CRN' => $request->CRN,
            'company_name' => $user->name,
            'city_id' => $request->city_id,
            'created_by' => Auth::id(),
            // 'presenter_name' => $request->presenter_name,
            'company_logo' => $request_data['company_logo'] ?? null,

        ]);

        // $Last_customer_id = User::latest()->value('customer_id');
        // if (!$Last_customer_id) {
        //     $new_customer_id = str_pad(1 + 1, 4, '0', STR_PAD_LEFT);
        // } else {
        //     $new_customer_id = str_pad($Last_customer_id + 1, 4, '0', STR_PAD_LEFT);
        // }


    // Create or update Subscription

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
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
            'id_number.unique' => 'The ID number has already been taken.', // Cus
            'id_number.required' => __('The ID number is required.'),

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
            'id_number' => $request->id_number,

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
            'id_number' => $request->id_number,
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

    public function storeNewBroker(Request $request)
    {


    // Validation rules
    $rules = [
        'full_phone' => 'required|unique:brokers,full_phone',
        'subscription_type_id' => 'required|exists:subscription_types,id',
        'license_number' => 'required|numeric|unique:brokers,broker_license',
        'broker_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ];

    $messages = [
        'name.required' => __('The name field is required.'),
        'email.required' => __('The email field is required.'),
        'email.unique' => __('The email has already been taken.'),
        'full_phone.required' => __('The mobile field is required.'),
        'full_phone.unique' => __('The mobile has already been taken.'),
        'subscription_type_id.required' => __('The subscription type field is required.'),
        'subscription_type_id.exists' => __('The selected subscription type is invalid.'),
        'license_number.required' => __('The license number field is required.'),
        'license_number.unique' => __('The license number has already been taken.'),
        'license_number.numeric' => __('The license number must be a number.'),
        'password.required' => __('The password field is required.'),
        'password.confirmed' => __('The password confirmation does not match.'),
        'broker_logo.image' => __('The broker logo must be an image.'),
        'id_number.numeric' => 'The ID number must be a number.',
        'id_number.digits' => 'The ID number must be exactly 10 digits long.',
        'id_number.unique' => 'The ID number has already been taken.',
        'id_number.required' => __('The ID number is required.'),
    ];

    // Validate the request
    $request->validate($rules, $messages);
    $request_data = [];

    if ($request->hasFile('broker_logo')) {
        $file = $request->file('broker_logo');
        $ext  =  uniqid() . '.' . $file->clientExtension();
        $file->move(public_path() . '/Brokers/' . 'Logos/', $ext);
        $request_data['broker_logo'] = '/Brokers/' . 'Logos/' . $ext;
    }


    // Check if the user already exists with incomplete data
    $user = User::where('email', $request->email)->first();

    if ($user) {
        // Update existing user
        $user->update([
            'is_broker' => 1,
            'customer_id' => $this->generateCustomerId(),
            'avatar' => $request_data['broker_logo'] ?? null,
        ]);
    } else {
        // Create a new user
        $user = User::create([
            'is_broker' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'phone' => $request->mobile,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'customer_id' => $this->generateCustomerId(),
            'avatar' => $request_data['broker_logo'] ?? null,
            'id_number' => $request->id_number,
        ]);
    }

    // Create or update Broker
    $broker = Broker::updateOrCreate(
        ['user_id' => $user->id],
        [
            'broker_license' => $request->license_number,
            'license_date' => $request->license_date,
            'mobile' => $user->phone,
            'key_phone' => $user->key_phone,
            'full_phone' => $user->full_phone,
            'city_id' => $request->city_id,
            'id_number' => $user->id_number,
            'broker_logo' => $request_data['broker_logo'] ?? 'HOME_PAGE/img/avatars/14.png',
        ]
    );

    // Create or update Subscription
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

    $subscription = Subscription::updateOrCreate(
        ['broker_id' => $broker->id],
        [
            'subscription_type_id' => $request->subscription_type_id,
            'status' => $subscriptionType->price > 0 ? 'pending' : 'active',
            'is_start' => $subscriptionType->price > 0 ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => $endDate,
            'total' => $subscriptionType->price,
        ]
    );

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
    }

    private function uploadFile($file)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->extension();
            $file->move(public_path('/Brokers/Logos'), $filename);
            return '/Brokers/Logos/' . $filename;
        }
        return null;
    }

    private function generateCustomerId()
    {
        $Last_customer_id = User::where('customer_id', '!=', null)->latest()->value('customer_id');
        $delimiter = '-';
        $prefixes = ['AMK1-', 'AMK2-', 'AMK3-', 'AMK4-', 'AMK5-', 'AMK6-'];

        if (!$Last_customer_id) {
            return 'AMK1-0001';
        } else {
            $result = explode($delimiter, $Last_customer_id);
            $number = (int)$result[1] + 1;
            $tag_index = min(intval($number / 1000), count($prefixes) - 1);
            $tag = $prefixes[$tag_index];
            return $tag . str_pad($number % 1000, 4, '0', STR_PAD_LEFT);
        }
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
        $fullPhone = session('phone');
        $phone = session('mobile');
        $KeyPhone = session('key_phone');


        $setting =   Setting::first();

        $termsAndConditionsUrl = $setting->terms_pdf;
        $privacyPolicyUrl = $setting->privacy_pdf;
        $Regions = Region::all();
        $cities = City::all();
        // $RolesIds = Role::whereIn('name', ['Property-Finder'])->pluck('id')->toArray();

        $RolesIds = Role::whereIn('name', ['Owner'])->pluck('id')->toArray();

        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();

        // $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('status', 1)
        //     ->whereIn('id', $RolesSubscriptionTypeIds)
        //     ->get();
        $subscriptionType = SubscriptionType::where('is_deleted', 0)
        ->where('new_subscriber', '1')
        ->where('status', 1)
        ->whereIn('id', $RolesSubscriptionTypeIds)
        ->first();
        return view('Home.Auth.propertyFinder.create', get_defined_vars());
    }



    public function storePropertyFinder(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,NULL,id,id_number,' . $request->id_number,
            'password' => 'required|string|max:255|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'account_type' => 'required|in:is_property_finder,is_owner',
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                function ($attribute, $value, $fail) use ($request) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail(__('The ID number must start with 1 or 2 and be exactly 10 digits long.'));
                    }

                    if ($request->account_type === 'is_owner') {
                        // Check if the ID number is already registered as an owner
                        $owner = User::where('is_owner', 1)->where('id_number', $value)->first();
                        if ($owner) {
                            $fail(__('This account is already registered as an owner.'));
                        }

                        // Check if the ID number is registered but not as an owner
                        $user = User::where('id_number', $value)
                            ->where('is_owner', 0)
                            ->first();

                        if ($user) {
                            session()->flash('modal_data', [
                                'name' => $user->name,
                                'email' => $user->email,
                                'id_number' => $user->id_number,
                                'account_type' => $this->getAccountType($user)
                            ]);
                            $fail(__('This account is already registered as a ' . $this->getAccountType($user) . '. Do you want to add them as an owner?'));
                        }

                    } elseif ($request->account_type === 'is_property_finder') {
                        // Check if the ID number is already registered as a property finder
                        $propertyFinder = User::where('is_property_finder', 1)->where('id_number', $value)->first();
                        if ($propertyFinder) {
                            $fail(__('This account is already registered as a property finder.'));
                        }

                        // Check if the ID number is registered but not as a property finder
                        $user = User::where('id_number', $value)
                            ->where('is_property_finder', 0)
                            ->first();

                        if ($user) {
                            $fail(__('This account is already registered as a ' . $this->getAccountType($user) ));
                        }
                    }
                },
            ],
        ];


        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'password.required' => __('The password field is required.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'avatar.image' => __('The broker logo must be an image.'),
            'id_number.required' => __('The ID number field is required.'),
            'id_number.numeric' => __('The ID number must be a number.'),
            'id_number.digits' => __('The ID number must be exactly 10 digits long.'),
        ];

        $request->validate($rules, $messages);

        $request_data = [];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext  = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
            $request_data['avatar'] = '/PropertyFounder/' . 'Logos/' . $ext;
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


            $user_data = [
                'name' => $request->name,
                'email' => $request->email,
                'key_phone' => $request->key_phone ?? null,
                'phone' => $request->phone ?? null,
                'full_phone' => $request->full_phone ?? null,
                'user_name' => uniqid(),
                'password' => bcrypt($request->password),
                'avatar' => $request_data['avatar'] ?? null,
                'id_number' => $request->id_number,
                'customer_id' => $new_customer_id,
            ];


            if ($request->account_type === 'is_property_finder') {
                session(['active_role' => 'Property-Finder']);
                $user_data['is_property_finder'] = 1;
            } else {
                $user_data['is_owner'] = 1;
            }

            $user = User::create($user_data);

            if ($request->account_type === 'is_owner') {
               $owner= Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'user_id' => $user->id,
                    'key_phone' => $request->key_phone ?? null,
                    'phone' => $request->phone ?? null,
                    'full_phone' => $request->full_phone ?? null,
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
                    'owner_id' => $owner->id,
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
                    'owner_id' => $owner->id,
                    'subscription_name' => $subscriptionType->name,
                    'amount' => $subscriptionType->price,
                    'subscription_type' => $SubType,
                    'period' => $subscriptionType->period,
                    'period_type' => $subscriptionType->period_type,
                    'status' => $status,
                    'invoice_ID' => 'INV-' . $new_invoice_ID,
                ]);

                session(['active_role' => 'Owner']);
            }
            $this->notifyAdmins2($user);
            auth()->loginUsingId($user->id);

            return redirect()->route('login')->withSuccess(__('Owner profile added successfully'));

    }

    public function createNewPropertyFinder()
    {
        $email = session('email');

        $setting =   Setting::first();

        $termsAndConditionsUrl = $setting->terms_pdf;
        $privacyPolicyUrl = $setting->privacy_pdf;
        $Regions = Region::all();
        $cities = City::all();
        $RolesIds = Role::whereIn('name', ['Property-Finder'])->pluck('id')->toArray();
        $newPropertyFinder = auth()->user();
        return view('Home.Auth.propertyFinder.CreatePropertyFinder', get_defined_vars());
    }



    public function storeNewPropertyFinder(Request $request)
    {
        $rules = [
            'account_type' => 'required|in:is_property_finder,is_owner',
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'password.required' => __('The password field is required.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'avatar.image' => __('The avatar must be an image.'),
            'id_number.required' => __('The ID number field is required.'),
            'id_number.numeric' => __('The ID number must be a number.'),
            'id_number.digits' => __('The ID number must be exactly 10 digits long.'),
        ];

        $request->validate($rules, $messages);

        $request_data = [];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext  = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
            $request_data['avatar'] = '/PropertyFounder/' . 'Logos/' . $ext;
        }

        $user = User::where('email', $request->email)->first();


        if ($user) {
            // Update existing user
            if ($request->account_type === 'is_property_finder') {
                session(['active_role' => 'Property-Finder']);
                $user->update([
                    'is_property_finder' => 1,
                ]);
            } else {
                $user->update([
                    'is_owner' => 1,
                ]);
                session(['active_role' => 'Owner']);
            }
        } else {
            $user_data = [
                'name' => $request->name,
                'email' => $request->email,
                'user_name' => uniqid(),
                'password' => bcrypt($request->password),
                'avatar' => $request_data['avatar'] ?? null,
                'id_number' => $request->id_number,
            ];

            if ($request->account_type === 'is_property_finder') {
                session(['active_role' => 'Property-Finder']);
                $user_data['is_property_finder'] = 1;
            } else {
                $user_data['is_owner'] = 1;
            }

            $user = User::create($user_data);
        }

        if ($request->account_type === 'is_owner') {
            $city_id = null;

            // Check if the user is a broker or an office and get the corresponding city_id
            if ($user->is_broker) {
                $city_id = $user->UserBrokerData->cityData->id ?? null;
            } elseif ($user->is_office) {
                $city_id = $user->UserOfficeData->cityData->id ?? null;
            }

            // Create the owner with the city_id
            Owner::create([
                'name' => $user->name,
                'email' => $user->email,
                'key_phone' => $user->key_phone ?? null,
                'phone' => $user->phone ?? null,
                'full_phone' => $user->full_phone,
                'city_id' => $city_id ?? null,
                'user_id' => $user->id,
                'balance' => $request->balance ?? 0,
            ]);

            session(['active_role' => 'Owner']);
        }

        $user->assignRole('Owner');
        $this->notifyAdmins2($user);
        auth()->loginUsingId($user->id);

        return redirect()->route('login')->withSuccess(__('Owner profile added successfully'));
    }



    public function addOwnerProfile(Request $request)
    {


        $user = User::where('id_number', $request->id_number)->first();

        if (!$user) {
            return redirect()->back()->withError(__('User not found.'));
        }

        // Update the user to be an owner
        $user->update(['is_owner' => 1]);

        // Create an owner profile
        Owner::create([
            'name' => $user->name,
            'email' => $user->email,
            'user_id' => $user->id,
        ]);

        // Notify admins or perform other actions
        $this->notifyAdmins2($user);

        // Log in the user
        auth()->loginUsingId($user->id);

        return redirect()->route('login')->withSuccess(__('Owner profile added successfully.'));
    }



    private function getAccountType($user)
    {
        if ($user->is_property_finder) {
            return 'property finder';
        } elseif ($user->is_renter) {
            return 'renter';
        } elseif ($user->is_employee) {
            return 'employee';
        } elseif ($user->is_broker) {
            return 'Broker';
        } elseif ($user->is_office) {
        return 'Office';
        }
        // Add more checks if needed
        return 'user';
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

    public function createAccount(Request $request)
    {
        $accountType = $request->query('accountType');
        $email = session('email');
        $fullPhone = session('phone');
        $KeyPhone = session('Key_phone');

        if($accountType == 'broker'){
            $RolesIds = Role::whereIn('name', ['RS-Broker'])->pluck('id')->toArray();
            $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
            $subscriptionType = SubscriptionType::where('is_deleted', 0)
            ->where('status', 1)
            ->where('new_subscriber', '1')
            ->whereIn('id', $RolesSubscriptionTypeIds)
            ->first();
        }elseif($accountType == 'office'){
            $RolesIds = Role::whereIn('name', ['Office-Admin'])->pluck('id')->toArray();
            $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
            $subscriptionType = SubscriptionType::where('is_deleted', 0)
            ->where('status', 1)
            ->where('new_subscriber', '1')
            ->whereIn('id', $RolesSubscriptionTypeIds)
            ->first();
        }elseif($accountType == 'owner'){
            $RolesIds = Role::whereIn('name', ['owner'])->pluck('id')->toArray();
            $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
            $subscriptionType = SubscriptionType::where('is_deleted', 0)
            ->where('status', 1)
            ->where('new_subscriber', '1')
            ->whereIn('id', $RolesSubscriptionTypeIds)
            ->first();
        }


        return view('auth.id-validation', get_defined_vars());
    }

    // public function register(Request $request)
    // {

    //     $request->validate([
    //         'id_number' => 'required|max:10',
    //         'email' => 'required|email|unique:users',
    //         'name' => 'required|string|max:255',
    //         'account_type' => 'required|string|in:broker,office,owner,property_finder',
    //     ]);

    //     $existingUser = User::where('email', $request->email)
    //                         ->orWhere('id_number', $request->id_number)
    //                         ->first();

    //     if ($existingUser) {
    //         return redirect()->back()->withErrors([
    //             'email' => __('This email or ID number is already registered.'),
    //         ])->withInput();
    //     }
    //     $isBroker = false;
    //     $isOffice = false;
    //     $isOwner = false;
    //     $isPropertyFinder = false;

    //     switch ($request->account_type) {
    //         case 'broker':
    //             $isBroker = true;
    //             break;
    //         case 'office':
    //             $isOffice = true;
    //             break;
    //         case 'owner':
    //             $isOwner = true;
    //             break;
    //         case 'property_finder':
    //             $isPropertyFinder = true;
    //             break;
    //     }

    //     dd($request);

    //     // Create a new user with account type flags
    //     $newUser = User::create([
    //         'id_number' => $request->id_number,
    //         'email' => $request->email,
    //         'name' => $request->name,
    //         'is_broker' => $isBroker,
    //         'is_office' => $isOffice,
    //         'is_owner' => $isOwner,
    //         'is_property_finder' => $isPropertyFinder,
    //     ]);

    //     // Log the user in
    //     auth()->login($newUser);

    //     // Redirect the user after successful registration
    //     return redirect()->route('home')->with('success', __('Registration successful.'));
    // }


    public function register(Request $request)
{
    $request->validate([
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
        'email' => 'required|email|unique:users',
        'name' => 'required|string|max:255',
        'account_type' => 'required|string|in:broker,office,owner,property_finder',
        'subscription_type_id' => 'required|exists:subscription_types,id', // Ensure this field is present in the request
        'license_number' => 'nullable|string', // Example for optional fields
        'broker_license' => 'nullable|string', // Example for optional fields
        'license_date' => 'nullable|date',
        'CRN' => 'nullable|string',
        'company_name' => 'nullable|string',
        'company_logo' => 'nullable|image',
        'broker_logo' => 'nullable|image',
        'key_phone' => 'nullable|string',
        'phone' => 'nullable|string',
        'full_phone' => 'nullable|string',
    ]);

    // Check if the user already exists
    $existingUser = User::where('email', $request->email)
                        ->orWhere('id_number', $request->id_number)
                        ->first();

    if ($existingUser) {
        return redirect()->back()->withErrors([
            'email' => __('This email or ID number is already registered.'),
        ])->withInput();
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

    // Create a new user
    $newUser = User::create([
        'id_number' => $request->id_number,
        'email' => $request->email,
        'name' => $request->name,
        'is_broker' => $request->account_type == 'broker',
        'is_office' => $request->account_type == 'office',
        'is_owner' => $request->account_type == 'owner',
        'is_property_finder' => $request->account_type == 'property_finder',
        'customer_id' => $new_customer_id,

    ]);

    // Handle account-specific logic
    if ($request->account_type == 'broker') {
        $this->handleBroker($request, $newUser);
    } elseif ($request->account_type == 'office') {
        $this->handleOffice($request, $newUser);
    } elseif ($request->account_type == 'owner') {
        $this->handleOwner($request, $newUser);
    }

    // Log the user in
    auth()->login($newUser);

    // Redirect the user after successful registration
    return redirect()->route('login')->with('success', __('registerd successfully'));
}

private function handleBroker($request, $user)
{


    $broker = Broker::create([
        'user_id' => $user->id,
        'broker_license' => null,
        'broker_logo' => $request->broker_logo ?? 'HOME_PAGE/img/avatars/14.png',
        'id_number' => $request->id_number,

    ]);

    $subscriptionType = SubscriptionType::find($request->subscription_type_id);
    $startDate = Carbon::now();
    $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');

    $status = $subscriptionType->price > 0 ? 'pending' : 'active';
    $SubType = $subscriptionType->price > 0 ? 'paid' : 'free';

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

    foreach ($subscriptionType->sections as $section) {
        SubscriptionSection::create([
            'section_id' => $section->id,
            'subscription_id' => $subscription->id,
        ]);
    }

    $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');
    $delimiter = '-';
    $new_invoice_ID = !$Last_invoice_ID ? '00001' : str_pad((int)explode($delimiter, $Last_invoice_ID)[1] + 1, 5, '0', STR_PAD_LEFT);

    $Invoice = SystemInvoice::create([
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
}

private function handleOffice($request, $user)
{
    $office = Office::create([
        'user_id' => $user->id,
        'CRN' => $request->CRN ?? null,
        'company_name' => $user->name,
        'created_by' => $user->id,
        'company_logo' => $request->company_logo ?? null,
    ]);

    $subscriptionType = SubscriptionType::find($request->subscription_type_id);
    $startDate = Carbon::now();
    $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');

    $status = $subscriptionType->price > 0 ? 'pending' : 'active';
    $SubType = $subscriptionType->price > 0 ? 'paid' : 'free';

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
    $new_invoice_ID = !$Last_invoice_ID ? '00001' : str_pad((int)explode($delimiter, $Last_invoice_ID)[1] + 1, 5, '0', STR_PAD_LEFT);

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

}

private function handleOwner($request, $user)
{
    $owner= Owner::create([
        'name' => $request->name,
        'email' => $request->email,
        'user_id' => $user->id,
        'key_phone' => $request->key_phone ?? null,
        'phone' => $request->phone ?? null,
        'full_phone' => $request->full_phone ?? null,
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
        'owner_id' => $owner->id,
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
        'owner_id' => $owner->id,
        'subscription_name' => $subscriptionType->name,
        'amount' => $subscriptionType->price,
        'subscription_type' => $SubType,
        'period' => $subscriptionType->period,
        'period_type' => $subscriptionType->period_type,
        'status' => $status,
        'invoice_ID' => 'INV-' . $new_invoice_ID,
    ]);

    session(['active_role' => 'Owner']);
    $this->notifyAdmins2($user);

}





}
