<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SubscriptionRepositoryInterface;
use App\Models\Broker;
use App\Models\Region;
use App\Models\City;
use App\Models\Role;
use App\Models\SubscriptionTypeRole;
use App\Models\SubscriptionType;
use App\Services\UserCreationService;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Office;
use App\Models\Subscription;
use App\Models\SystemInvoice;
use App\Notifications\Admin\NewOfficeNotification;
use App\Services\OfficeCreationService;
use App\Services\BrokerCreationService;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
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

        $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d');

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
        ];

        validator($data, $rules)->validate();

        $user = $this->userCreationService->createBroker($data);


        $broker = $this->brokerCreationService->createBroker($data, $user);


        $subscriptionType = SubscriptionType::find($data['subscription_type_id']);

        $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d');

        $status = ($subscriptionType->price > 0) ? 'pending' : 'active';

        $subscription = $this->subscriptionRepository->createBrokerSubscriber([
            'broker_id' => $broker->id,
            'subscription_type_id' => $data['subscription_type_id'],
            'status' => $status,
            'is_start' => ($status == 'pending') ? 0 : 1,
            'is_new' => 1,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => $endDate,
            'total' => '200'
        ]);

        $this->createSystemInvoice($broker, $subscriptionType, $status);

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
    protected function validateData(array $data, array $rules)
    {
        return request()->validate($rules);
    }


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


    public function suspendSubscription($id, $isSuspend)
    {
        $this->subscriptionRepository->suspendSubscription($id, $isSuspend);
    }

}
