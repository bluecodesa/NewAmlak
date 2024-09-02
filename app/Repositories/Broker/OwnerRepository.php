<?php

namespace App\Repositories\Broker;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Str;
use App\Http\Traits\Email\MailOwnerCredentials;

class OwnerRepository
{
    use MailOwnerCredentials;

    public function getAllByBrokerId($brokerId)
    {
        return Owner::where('broker_id', $brokerId)->get();
    }

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

        $broker_id = auth()->user()->UserBrokerData->id;

        $user = User::where('id_number', $data['id_number'])->first();

            $password = Str::random(8);
            $user = User::create([
                'is_owner' => 1,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'key_phone' => $data['key_phone'],
                'full_phone' => $data['full_phone'],
                'id_number' => $data['id_number'],
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

            // Add to pivot table
            $owner->brokers()->attach($data['broker_id'], [
                'broker_id' => $broker_id,
                'balance' => $data['balance'] ?? 0,
            ]);

            $this->MailOwnerCredentials($user, $password);

            return response()->json([
                'message' => __('New owner has been successfully created and associated with the current broker.'),
                'owner' => $owner,
            ], 201);

    }

    // public function create($data)
    // {
    //     // Validation rules
    //     $rules = [
    //         'name' => 'required|string|max:255',
    //         'city_id' => 'required|exists:cities,id',
    //         'id_number' => [
    //             'required',
    //             'string',
    //             'max:25',
    //             function ($attribute, $value, $fail) use ($data) {
    //                 if (!preg_match('/^[12]\d{9}$/', $value)) {
    //                     $fail(__('The ID number must start with 1 or 2 and be exactly 10 digits long.'));
    //                 }

    //                 // Additional checks for existing users and owners
    //                 $user = User::where('id_number', $value)->first();
    //                 if ($user) {
    //                     if (!$user->is_owner) {
    //                         $fail(__('This user is already registered as a ' . $user->role . '. Do you want to register this user as an owner?'));
    //                     } else {
    //                         $owner = Owner::where('user_id', $user->id)->first();
    //                         if ($owner) {
    //                             $exists = DB::table('owner_office_broker')
    //                                 ->where('owner_id', $owner->id)
    //                                 ->where('broker_id', $data['broker_id'])
    //                                 ->exists();

    //                             if ($exists) {
    //                                 $fail(__('This owner is already associated with the current broker.'));
    //                             }
    //                         }
    //                     }
    //                 }
    //             },
    //         ],
    //         'email' => [
    //             'required',
    //             'email',
    //             'max:255',
    //             Rule::unique('users', 'email')->ignore($data['id_number'], 'id_number'),
    //         ],
    //         'full_phone' => [
    //             'required',
    //             'max:25',
    //             Rule::unique('users', 'full_phone')->ignore($data['id_number'], 'id_number'),
    //         ],
    //         'balance' => 'numeric|min:0',
    //     ];

    //     $messages = [
    //         'name.required' => __('The name field is required.'),
    //         'name.string' => __('The name must be a string.'),
    //         'name.max' => __('The name may not be greater than :max characters.'),
    //         'city_id.required' => __('The city field is required.'),
    //         'city_id.exists' => __('The selected city is invalid.'),
    //         'id_number.required' => __('The ID number is required.'),
    //         'id_number.string' => __('The ID number must be a string.'),
    //         'id_number.max' => __('The ID number may not be greater than :max characters.'),
    //         'email.required' => __('The email field is required.'),
    //         'email.email' => __('The email must be a valid email address.'),
    //         'email.unique' => __('The email has already been taken.'),
    //         'email.max' => __('The email may not be greater than :max characters.'),
    //         'full_phone.required' => __('The phone field is required.'),
    //         'full_phone.unique' => __('The phone has already been taken.'),
    //         'full_phone.max' => __('The phone may not be greater than :max characters.'),
    //         'balance.numeric' => __('The balance must be a number.'),
    //         'balance.min' => __('The balance must be at least 0.'),
    //     ];

    //     // Validate the data
    //     validator($data, $rules, $messages)->validate();

    //     $broker_id = auth()->user()->UserBrokerData->id;

    //     // Check if user with this id_number exists
    //     $user = User::where('id_number', $data['id_number'])->first();
    //     if ($user) {
    //         if (!$user->is_owner) {
    //             return response()->json([
    //                 'status' => 'exists_not_owner',
    //                 'message' => __('This user is already registered as a ' . $user->role . '. Do you want to register this user as an owner?'),
    //                 'user' => $user,
    //             ]);
    //         } else {
    //             // Check if this user is an owner
    //             $owner = Owner::where('user_id', $user->id)->first();
    //             if ($owner) {
    //                 // Check if this owner is already associated with the same broker in the pivot table
    //                 $exists = DB::table('owner_office_broker')
    //                             ->where('owner_id', $owner->id)
    //                             ->where('broker_id', $broker_id)
    //                             ->exists();

    //                 if ($exists) {
    //                     return response()->json([
    //                         'message' => __('This owner is already associated with the current broker.')
    //                     ], 409);
    //                 } else {
    //                     // Add to pivot table if not already associated
    //                     $owner->brokers()->attach($data['broker_id'], [
    //                         'broker_id' => $broker_id,
    //                         'balance' => $data['balance'] ?? 0,
    //                     ]);

    //                     return response()->json([
    //                         'message' => __('Owner has been successfully associated with the current broker.'),
    //                         'owner' => $owner,
    //                     ], 201);
    //                 }
    //             } else {
    //                 // Create a new owner if the user exists but is not yet an owner
    //                 $owner = Owner::create([
    //                     'name' => $data['name'],
    //                     'email' => $data['email'],
    //                     'full_phone' => $data['full_phone'],
    //                     'city_id' => $data['city_id'],
    //                     'user_id' => $user->id,
    //                     'balance' => $data['balance'] ?? 0,
    //                 ]);

    //                 // Add to pivot table
    //                 $owner->brokers()->attach($data['broker_id'], [
    //                     'broker_id' => $broker_id,
    //                     'balance' => $data['balance'] ?? 0,
    //                 ]);

    //                 return response()->json([
    //                     'message' => __('Owner has been successfully created and associated with the current broker.'),
    //                     'owner' => $owner,
    //                 ], 201);
    //             }
    //         }
    //     } else {
    //         // Create a new user and owner if the user does not exist
    //         $password = Str::random(8); // Generate a random password
    //         $user = User::create([
    //             'is_owner' => 1,
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'full_phone' => $data['full_phone'],
    //             'id_number' => $data['id_number'],
    //             'password' => Hash::make($password),
    //         ]);

    //         $owner = Owner::create([
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'full_phone' => $data['full_phone'],
    //             'city_id' => $data['city_id'],
    //             'user_id' => $user->id,
    //             'balance' => $data['balance'] ?? 0,
    //         ]);

    //         // Add to pivot table
    //         $owner->brokers()->attach($data['broker_id'], [
    //             'broker_id' => $broker_id,
    //             'balance' => $data['balance'] ?? 0,
    //         ]);

    //         $this->MailOwnerCredentials($user, $password);

    //         return response()->json([
    //             'message' => __('New owner has been successfully created and associated with the current broker.'),
    //             'owner' => $owner,
    //         ], 201);
    //     }
    // }


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
