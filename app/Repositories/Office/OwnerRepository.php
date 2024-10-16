<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\OwnerRepositoryInterface;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Str;
use App\Http\Traits\Email\MailOwnerCredentials;
use App\Http\Traits\WhatsApp\WhatsAppAccountCredentials;
use App\Models\OwnerOfficeBroker;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Models\SubscriptionTypeRole;
use App\Models\SystemInvoice;
use App\Models\User;
use Carbon\Carbon;


class OwnerRepository implements OwnerRepositoryInterface
{
    use MailOwnerCredentials;
    use WhatsAppAccountCredentials;

    public function getAllByOfficeId($officeId)
    {

        return Owner::where('office_id', $officeId)->get();
    }

    // public function create($data)
    // {
    //     return Owner::create($data);
    // }
    public function create($data)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'id_number' => [
                'required',
                'string',
                'max:25',
                function ($attribute, $value, $fail) use ($data) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail(__('The ID number must start with 1 or 2 and be exactly 10 digits long.'));
                    }
                }
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
            'balance' => 'numeric|min:0',
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'name.string' => __('The name must be a string.'),
            'name.max' => __('The name may not be greater than :max characters.'),
            'city_id.required' => __('The city field is required.'),
            'city_id.exists' => __('The selected city is invalid.'),
            'id_number.required' => __('The ID number is required.'),
            'id_number.string' => __('The ID number must be a string.'),
            'id_number.max' => __('The ID number may not be greater than :max characters.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.unique' => __('The email has already been taken.'),
            'email.max' => __('The email may not be greater than :max characters.'),
            'full_phone.required' => __('The phone field is required.'),
            'full_phone.unique' => __('The phone has already been taken.'),
            'full_phone.max' => __('The phone may not be greater than :max characters.'),
            'balance.numeric' => __('The balance must be a number.'),
            'balance.min' => __('The balance must be at least 0.'),
        ];

        // Validate the data
        validator($data, $rules, $messages)->validate();

        $office_id = auth()->user()->UserOfficeData->id;

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
            $user = User::create([
                'is_owner' => 1,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'key_phone' => $data['key_phone'],
                'full_phone' => $data['full_phone'],
                'id_number' => $data['id_number'],
                'customer_id' => $new_customer_id,
                'password' => Hash::make($password),
            ]);

            $owner = Owner::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'key_phone' => $data['key_phone'],
                'full_phone' => $data['full_phone'],
                'city_id' => $data['city_id'],
                'user_id' => $user->id,
                'balance' => $data['balance'] ?? 0,
            ]);

            $RolesIds = Role::whereIn('name', ['Owner'])->pluck('id')->toArray();
            $RolesSubscriptionTypeIds = SubscriptionTypeRole::whereIn('role_id', $RolesIds)->pluck('subscription_type_id')->toArray();
            $subscriptionType = SubscriptionType::where('is_deleted', 0)
            ->where('status', 1)
            ->where('new_subscriber', '1')
            ->whereIn('id', $RolesSubscriptionTypeIds)
            ->first();
            $subscription_type_id = $subscriptionType->id;

            $subscriptionType = SubscriptionType::find($subscription_type_id);
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
            'subscription_type_id' => $subscription_type_id,
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

        $user->assignRole('Owner');

            // Add to pivot table
            $owner->offices()->attach($data['office_id'], [
                'office_id' => $office_id,
                'balance' => $data['balance'] ?? 0,
            ]);

            $this->MailOwnerCredentials($user, $password);
            $this->WhatsAppAccountCredentials($user, $password);

            return response()->json([
                'message' => __('New owner has been successfully created and associated with the current Office.'),
                'owner' => $owner,
            ], 201);

    }


    function getOwnerById($id)
    {
        return Owner::find($id);
    }

    public function updateOwner($id, $data)
    {
        $Owner = Owner::findOrFail($id);
        $Owner->update($data);
        return $Owner;
    }

    public function deleteOwner($id)
    {
        return Owner::findOrFail($id)->delete();
    }
}
