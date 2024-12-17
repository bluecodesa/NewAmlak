<?php

namespace App\Services\Admin;

use App\Http\Traits\Email\MailWelcomeBroker;
use App\Interfaces\Admin\SubscriptionRepositoryInterface;
use App\Models\Broker;
use App\Models\Gallery;
use App\Models\Office;
use App\Models\ServiceProvider;
use App\Models\SubscriptionHistory;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Notifications\Admin\NewBrokerNotification;
use App\Services\UserCreationService;
use Illuminate\Validation\Rule;
use App\Models\SystemInvoice;
use App\Models\User;
use App\Notifications\Admin\NewOfficeNotification;
use App\Services\OfficeCreationService;
use App\Services\BrokerCreationService;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Models\Role;
use Str;
use App\Http\Traits\Email\MailOwnerCredentials;
use App\Http\Traits\WhatsApp\WhatsAppAccountCredentials;

class SubscriptionService
{
    use MailWelcomeBroker;
    use MailOwnerCredentials;
    use WhatsAppAccountCredentials;

    protected $subscriptionRepository;
    protected $userCreationService;
    protected $officeCreationService;
    protected $brokerCreationService;


    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository, UserCreationService $userCreationService, OfficeCreationService $officeCreationService, BrokerCreationService $brokerCreationService)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userCreationService = $userCreationService;
        $this->officeCreationService = $officeCreationService;
        $this->brokerCreationService = $brokerCreationService;
    }

    public function getAllSubscribers()
    {
        return $this->subscriptionRepository->getAllSubscribers();
    }

    public function getAllUsers()
    {
        return $this->subscriptionRepository->getAllUsers();
    }

    public function findUserById($id)
    {
        return $this->subscriptionRepository->findUserById($id);
    }

    public function findSubscriptionById($id)
    {
        return $this->subscriptionRepository->findSubscriberById($id);
    }
    public function findSubscriptionByBrokerId($brokerId)
    {
        return $this->subscriptionRepository->findSubscriptionByBrokerId($brokerId);
    }
    public function findSubscriptionByOfficeId($officeId)
    {
        return $this->subscriptionRepository->findSubscriptionByOfficeId($officeId);
    }

    public function createOfficeSubscription(array $data)
    {
        $request = request();

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
        validator($data, $rules,$messages)->validate();

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path('Offices/Logos'), $fileName);
            $data['company_logo'] = '/Offices/Logos/' . $fileName;
        }

        // User creation
        $user = $this->userCreationService->createOffice($data);

        // Office creation
        $office = $this->officeCreationService->createOffice($data, $user);

        $subscriptionType = SubscriptionType::find($request['subscription_type_id']);

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
                'office_id' => $office->id,
                'gallery_name' => $galleryName,
                'gallery_status' => 1,
                'gallery_cover' => $defaultCoverImage,
            ]);
        } else {
            $gallery = null;
        }


        $endDate = $subscriptionType->calculateEndDate(Carbon::now());

        // Set the desired time (e.g., 23:59:59)
        $endDate->setHour(23)->setMinute(59)->setSecond(59);

        // Format the end date
        // $endDate = $endDate->format('Y-m-d H:i:s');

        $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');


        $status = ($subscriptionType->price > 0) ? 'pending' : 'active';

        $subscription = $this->subscriptionRepository->createOfficeSubscriber([
            'office_id' => $office->id,
            'subscription_type_id' => $request['subscription_type_id'],
            'status' => $status,
            'is_start' => ($status == 'pending') ? 0 : 1,
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

        $this->notifyAdminsForOffice($office);

        // Create system invoice
        $this->createSystemInvoice($office, $subscriptionType, $status);

        return $subscription;
    }

    protected function notifyAdminsForOffice(Office $office)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewOfficeNotification($office));
        }
    }


    public function createBrokerSubscription(array $data)
    {
        $request = request();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'full_phone' => 'required|unique:brokers,full_phone',
            'city_id' => 'required|exists:cities,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'license_number' => 'required|string|max:255|unique:brokers,broker_license',
            'password' => 'required|string|max:255|confirmed',
            'broker_logo' => 'file',
            'id_number' => 'nullable|unique:brokers,id_number'

        ];
        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'full_phone.required' => __('The mobile field is required.'),
            'full_phone.unique' => __('The mobile has already been taken.'),
            'full_phone.digits' => __('The mobile must be 9 digits.'),
            'license_number.required' => __('The license number field is required.'),
            'license_number.unique' => __('The license number has already been taken.'),
            'password.required' => __('The password field is required.'),
            'broker_logo.image' => __('The broker logo must be an image.'),
            'id_number.unique' => __('The ID number has already been taken.'),
            'password.confirmed' => __('The password confirmation does not match.'),


        ];

        validator($data, $rules, $messages)->validate();

        if ($request->hasFile('broker_logo')) {
            $file = $request->file('broker_logo');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path('Brokers/Logos'), $fileName);
            $data['broker_logo'] = '/Brokers/Logos/' . $fileName;
        }

        $user = $this->userCreationService->createBroker($data);


        $broker = $this->brokerCreationService->createBroker($data, $user);

        $subscriptionType = SubscriptionType::find($data['subscription_type_id']);

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

        ///
        $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');

        $status = ($subscriptionType->price > 0) ? 'pending' : 'active';

        $subscription = $this->subscriptionRepository->createBrokerSubscriber([
            'broker_id' => $broker->id,
            'subscription_type_id' => $data['subscription_type_id'],
            'status' => $status,
            'is_start' => ($status == 'pending') ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => $endDate,
            'total' => $subscriptionType->price
        ]);
        foreach ($subscriptionType->sections()->get() as $section_id) {
            SubscriptionSection::create([
                'section_id' => $section_id->id,
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
            'subscription_type' => ($subscriptionType->price > 0) ? 'paid' : 'free',
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ]);
        // $this->createSubscriptionHistory($subscription);


        // $this->createSystemInvoiceBroker($broker, $subscriptionType, $status);

        $this->notifyAdmins($broker);
        $this->MailWelcomeBroker($user, $subscription, $subscriptionType, $Invoice);

        return $subscription;
    }

    protected function createSubscriptionHistory($subscription)
    {
        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'start_date' => $subscription->start_date,
            'end_date' => $subscription->end_date,
            'status' => $subscription->status,
            // Add other attributes you want to track
        ]);
    }

    protected function notifyAdmins(Broker $broker)
    {
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::send($admin, new NewBrokerNotification($broker));
        }
    }


    public function updateSubscription($id, array $data)
    {
        return $this->subscriptionRepository->updateSubscriber($id, $data);
    }

    public function deleteSubscription($id)
    {
        return $this->subscriptionRepository->deleteSubscriber($id);
    }


    //////



    protected function uploadCompanyLogo($request)
    {
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;
            $file->move(public_path('Offices/Logos'), $fileName);
            $data['company_logo'] = '/Offices/Logos/' . $fileName;
        }
        return null;
    }



    protected function createSystemInvoice($office, $subscriptionType, $status)
    {
        $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');

        $delimiter = '-';
        if (!$Last_invoice_ID) {
            $new_invoice_ID = '00001';
        } else {
            $result = explode($delimiter, $Last_invoice_ID);
            $number = (int)$result[1] + 1;
            $new_invoice_ID = str_pad($number % 10000, 5, '0', STR_PAD_LEFT);
        }
        SystemInvoice::create([
            'office_id' => $office->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => ($subscriptionType->price > 0) ? 'paid' : 'free',
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ]);
    }

    protected function createSystemInvoiceBroker($broker, $subscriptionType, $status)
    {
        $Last_invoice_ID = SystemInvoice::where('invoice_ID', '!=', null)->latest()->value('invoice_ID');

        $delimiter = '-';
        if (!$Last_invoice_ID) {
            $new_invoice_ID = '00001';
        } else {
            $result = explode($delimiter, $Last_invoice_ID);
            $number = (int)$result[1] + 1;
            $new_invoice_ID = str_pad($number % 10000, 5, '0', STR_PAD_LEFT);
        }
        SystemInvoice::create([
            'broker_id' => $broker->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => ($subscriptionType->price > 0) ? 'paid' : 'free',
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV-' . $new_invoice_ID,
        ]);
    }


    public function suspendSubscription($id, $isSuspend)
    {
        $this->subscriptionRepository->suspendSubscription($id, $isSuspend);
    }

    public function getSubscriptionTypesForBroker()
    {
        return SubscriptionType::where('is_deleted', 0)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'RS-Broker');
            })
            ->get();
    }

    public function getSubscriptionTypesForOffice()
    {
        return SubscriptionType::where('is_deleted', 0)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Office-Admin');
            })
            ->get();
    }

    public function createServiceProvider(array $data)
    {
        // dd($data);
            // Validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'city_id' => 'required|exists:cities,id',
                'id_number' => [
                    'required',
                    'string',
                    'max:10', // Ensures the maximum length is 10
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^7\d{9}$/', $value)) {
                            $fail(__('The National number must start with 7 and be exactly 10 digits long.'));
                        }
                    },
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($data['id_number'], 'id_number'),
                ],
                'full_phone' => [
                    'required',
                    'max:25',
                    Rule::unique('users', 'full_phone')->ignore($data['id_number'], 'id_number'),
                ],
                'CRN' => [
                    'required',
                    Rule::unique('service_providers'),
                    'max:10'
                ],
            ];

            $messages = [
                'name.required' => __('The name field is required.'),
                'name.string' => __('The name must be a string.'),
                'name.max' => __('The name may not be greater than :max characters.'),
                'city_id.required' => __('The city field is required.'),
                'city_id.exists' => __('The selected city is invalid.'),
                'id_number.required' => __('The National number is required.'),
                'id_number.string' => __('The National number must be a string.'),
                'id_number.max' => __('The National number may not be greater than :max characters.'),
                'email.required' => __('The email field is required.'),
                'email.email' => __('The email must be a valid email address.'),
                'email.unique' => __('The email has already been taken.'),
                'email.max' => __('The email may not be greater than :max characters.'),
                'full_phone.required' => __('The phone field is required.'),
                'full_phone.unique' => __('The phone has already been taken.'),
                'full_phone.max' => __('The phone may not be greater than :max characters.'),
                'balance.numeric' => __('The balance must be a number.'),
                'balance.min' => __('The balance must be at least 0.'),
                'CRN.required' => __('The CRN field is required.'),
                'CRN.unique' => __('The CRN has already been taken.'),
                'CRN.max' => __('The CRN may not be greater than :max characters.'),
            ];

            // Validate the data
            validator($data, $rules, $messages)->validate();

            $user = User::where('id_number', $data['id_number'])->first();

            $password = Str::random(8);
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

                if ($data['avatar']) {
                    $file = $data['avatar'];
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid() . '.' . $ext;
                    $file->move(public_path('ServiceProviders/Logos'), $fileName);
                    $data['avatar'] = '/ServiceProviders/Logos/' . $fileName;
                }

                $user = User::create([
                    'is_service_provider' => 1,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'key_phone' => $data['key_phone'],
                    'full_phone' => $data['full_phone'],
                    'id_number' => $data['id_number'],
                    'customer_id' => $new_customer_id,
                    'password' => Hash::make($password),
                    'avatar' => $data['avatar'] ?? null,
                ]);

                $serviceProvider = ServiceProvider::create([
                    'user_id' => $user->id,
                    'CRN' => $data['CRN'],
                    'city_id' => $data['city_id'],
                ]);

                $RolesIds = Role::whereIn('name', ['service-povider'])->pluck('id')->toArray();
                $user->assignRole('service-povider');

                $this->MailOwnerCredentials($user, $password);
                $this->WhatsAppAccountCredentials($user, $password);


                return $serviceProvider;

    }



}
