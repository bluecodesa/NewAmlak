<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Traits\Email\MailWelcomeBroker;
use App\Models\Gallery;
use App\Notifications\Admin\NewBrokerNotification;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Office;
use App\Models\Region;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Broker;
use App\Models\Setting;
use App\Models\SystemInvoice;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionTypeRole;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use App\Services\Admin\SubscriptionTypeService;
use App\Services\Admin\SectionService;


class HomeController extends Controller
{
    use MailWelcomeBroker;


    protected $subscriptionTypeService;
    protected $SectionService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService, SectionService $SectionService)
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
        $this->SectionService = $SectionService;
    }



    public function index()
    {
        //subscrptions
        $subscriptionTypes = $this->subscriptionTypeService->getAll()
            ->where('is_deleted', 0)
            ->where('is_show', 1)
            ->where('status', 1);
        $sections = $this->SectionService->getAll();
        ////
        $RolesIds = Role::whereIn('name', ['RS-Broker'])->pluck('id')->toArray();
        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
        $subscriptionTypesRoles = $this->subscriptionTypeService->getAll()
            ->where('is_deleted', 0)->where('is_show', 1)->where('status', 1)
            ->whereIn('id', $RolesSubscriptionTypeIds);

        ///
        $sitting =   Setting::first();
        if ($sitting->active_home_page == 1) {
            return view('Home.home', get_defined_vars());
        } else {
            return redirect()->route('Admin.home', get_defined_vars());
        }
    }

    public function showRegion($id)
    {
        $region = Region::findOrFail($id);
        $cities = $region->cities;
        return response()->json($cities);
    }



    public function createBroker()
    {
        $setting =   Setting::first();

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
        $setting =   Setting::first();

        $termsAndConditionsUrl = $setting->terms_pdf;
        $privacyPolicyUrl = $setting->privacy_pdf;
        $Regions = Region::all();
        $cities = City::all();
        $RolesIds = Role::whereIn('name', ['Office-Admin'])->pluck('id')->toArray();

        $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();

        $subscriptionTypes = SubscriptionType::where('is_deleted', 0)->where('is_show', 1)->where('status', 1)->whereIn('id', $RolesSubscriptionTypeIds)->get();

        $subscriptionTypes = SubscriptionType::whereHas('Roles', function ($query) {
            $query->where('name', 'Office-Admin');
        })->get();

        return view('Home.Auth.office.create', get_defined_vars());
    }


    public function storeOffice(Request $request)
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
            $status = 'paid';
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

        return redirect()->route('login')->withSuccess(__('added successfully'));
    }

    public function storeBroker(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'full_phone' => 'required|unique:brokers,full_phone',
            'city_id' => 'required|exists:cities,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'license_number' => 'required|numeric|unique:brokers,broker_license',
            'password' => 'required|string|max:255|confirmed',
            'broker_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'id_number' => 'nullable|unique:brokers,id_number'

        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'full_phone.required' => __('The mobile field is required.'),
            'full_phone.unique' => __('The mobile has already been taken.'),
            'full_phone.digits' => __('The mobile must be 9 digits.'),
            'city_id.required' => __('The city field is required.'),
            'city_id.exists' => __('The selected city is invalid.'),
            'subscription_type_id.required' => __('The subscription type field is required.'),
            'subscription_type_id.exists' => __('The selected subscription type is invalid.'),
            'license_number.required' => __('The license number field is required.'),
            'license_number.unique' => __('The license number has already been taken.'),
            'license_number.numeric' => __('The license number must be a number.'),
            'password.required' => __('The password field is required.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'broker_logo.image' => __('The broker logo must be an image.'),
            'id_number.unique' => __('The ID number has already been taken.')
        ];


        $request->validate($rules, $messages);

        $request_data = [];

        if ($request->hasFile('broker_logo')) {
            $file = $request->file('broker_logo');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Brokers/' . 'Logos/', $ext);
            $request_data['broker_logo'] = '/Brokers/' . 'Logos/' . $ext;
        }

        $user = User::create([
            'is_broker' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => uniqid(),
            'password' => bcrypt($request->password),
            'avatar' => $request_data['broker_logo'] ?? null, // Use null coalescing operator to handle if no logo
        ]);

        // Create Broker
        $broker = Broker::create([
            'user_id' => $user->id,
            'broker_license' => $request->license_number,
            'mobile' => $request->mobile,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'city_id' => $request->city_id,
            'id_number' => $request->id_number ?? null,
            'broker_logo' => $request_data['broker_logo'] ?? null, // Use null coalescing operator to handle if no logo
        ]);


        $subscriptionType = SubscriptionType::find($request->subscription_type_id); // Or however you obtain your instance
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
        $Invoice =   SystemInvoice::create([
            'broker_id' => $broker->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => $SubType,
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV_' . uniqid(),
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

        $this->notifyAdmins($broker);

        $this->MailWelcomeBroker($user, $subscription, $subscriptionType, $Invoice);
        return redirect()->route('login')->withSuccess(__('Broker created successfully.'));
    }

    protected function notifyAdmins(Broker $broker)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewBrokerNotification($broker));
        }
    }


    public function UpdateToken(Request $request)
    {
        $user = User::find(Auth::id());
        $user->update(['fcm_token' => $request->token]);
    }

    public function showAllBrokers(Request $request)
    {


        $users = User::whereHas('UserBrokerData.GalleryData')->paginate(9);

        return view('Home.Brokers.index', get_defined_vars());
    }

    public function loadMoreBrokers(Request $request)
    {
        $brokers = User::where('is_broker', 1)->paginate(3);
        return view('Home.Brokers.inc._brokers', compact('brokers'));
    }
}
