<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SubscriptionRepositoryInterface;
use App\Models\Region;
use App\Models\City;
use App\Models\Role;
use App\Models\SubscriptionTypeRole;
use App\Models\SubscriptionType;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Office;
use App\Models\Subscription;
use App\Models\SystemInvoice;
use App\Notifications\Admin\NewOfficeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;






class SubscriptionService
{
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
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

        $validatedData = $this->validateData($data, $rules);

        $request_data = $this->uploadCompanyLogo($request);

        $user = User::create([
            'is_office' => 1,
            'name' => $request['name'],
            'email' => $request['email'],
            'user_name' => uniqid(),
            'password' => bcrypt($request['password']),
            'avatar' => $request['company_logo'],
        ]);

        $office = Office::create([
            'user_id' => $user->id,
            'CRN' => $request['CRN'],
            'company_name' => $user->name,
            'city_id' => $request['city_id'],
            'created_by' => Auth::id(),
            'presenter_name' => $request['presenter_name'],
            'presenter_number' => $request['presenter_number'],
            'company_logo' => $request['company_logo'],
        ]);

        $this->notifyAdmin($office);

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
        return $this->subscriptionRepository->createBrokerSubscriber($data);
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
            $ext  = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Offices/' . 'Logos/', $ext);
            $company_logo_path = '/Offices/' . 'Logos/' . $ext;
            return $company_logo_path;
        }
        return null;
    }


    protected function notifyAdmin($office)
    {
        $users = User::where('is_admin', true)->get();
        foreach ($users as $user) {
            Notification::send($user, new NewOfficeNotification($office));
        }
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

}
