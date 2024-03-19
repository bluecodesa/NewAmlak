<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SubscriptionRepositoryInterface;
use App\Models\Gallery;
use App\Models\SubscriptionType;
use App\Services\UserCreationService;
use Illuminate\Validation\Rule;
use App\Models\SystemInvoice;
use App\Notifications\Admin\NewOfficeNotification;
use App\Services\OfficeCreationService;
use App\Services\BrokerCreationService;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SubscriptionService
{
    protected $subscriptionRepository;
    protected $userCreationService;
    protected $officeCreationService;
    protected $brokerCreationService;


    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository,UserCreationService $userCreationService,OfficeCreationService $officeCreationService,BrokerCreationService $brokerCreationService)
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

    public function findSubscriptionById($id)
    {
        return $this->subscriptionRepository->findSubscriberById($id);
    }
    public function findSubscriptionByBrokerId($brokerId)
    {
        return $this->subscriptionRepository->findSubscriptionByBrokerId($brokerId);
    }

    public function createOfficeSubscription(array $data)
    {
        $request = request();

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

        validator($data, $rules)->validate();

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

        // $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d');
        // Calculate the end date
$endDate = $subscriptionType->calculateEndDate(Carbon::now());

// Set the desired time (e.g., 23:59:59)
$endDate->setHour(23)->setMinute(59)->setSecond(59);

// Format the end date
$endDate = $endDate->format('Y-m-d H:i:s');


        $status = ($subscriptionType->price > 0) ? 'pending' : 'active';

        $subscription=$this->subscriptionRepository->createOfficeSubscriber([
            'office_id' => $office->id,
            'subscription_type_id' => $request['subscription_type_id'],
            'status' => $status,
            'is_start' => ($status == 'pending') ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => $endDate,
            'total' => '200'
        ]);

        // Create system invoice
        $this->createSystemInvoice($office, $subscriptionType, $status);

        return $subscription;

    }


    public function createBrokerSubscription(array $data)
    {
        $request = request();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'mobile' => 'required|unique:brokers,mobile|digits:9',
            'city_id' => 'required|exists:cities,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'license_number' => 'required|string|max:255|unique:brokers,broker_license',
            'password' => 'required|string|max:255|confirmed',
            'broker_logo' => 'file',
            'id_number'=>'nullable|unique:brokers,id_number'

        ];
        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'mobile.required' => __('The mobile field is required.'),
            'mobile.unique' => __('The mobile has already been taken.'),
            'mobile.digits' => __('The mobile must be 9 digits.'),
            'license_number.required' => __('The license number field is required.'),
            'license_number.unique' => __('The license number has already been taken.'),
            'password.required' => __('The password field is required.'),
            'broker_logo.image' => __('The broker logo must be an image.'),
            'id_number.unique' => __('The ID number has already been taken.'),

        ];

        validator($data, $rules,$messages)->validate();

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

        $this->createSystemInvoiceBroker($broker, $subscriptionType, $status);


        return $subscription;
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
        SystemInvoice::create([
            'office_id' => $office->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => ($subscriptionType->price > 0) ? 'paid' : 'free',
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV_' . uniqid(),
        ]);
    }

    protected function createSystemInvoiceBroker($broker, $subscriptionType, $status)
    {
        SystemInvoice::create([
            'broker_id' => $broker->id,
            'subscription_name' => $subscriptionType->name,
            'amount' => $subscriptionType->price,
            'subscription_type' => ($subscriptionType->price > 0) ? 'paid' : 'free',
            'period' => $subscriptionType->period,
            'period_type' => $subscriptionType->period_type,
            'status' => $status,
            'invoice_ID' => 'INV_' . uniqid(),
        ]);
    }


    public function suspendSubscription($id, $isSuspend)
    {
        $this->subscriptionRepository->suspendSubscription($id, $isSuspend);
    }

}
