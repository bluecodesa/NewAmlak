<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\RenterRepositoryInterface;
use App\Models\Office;
use App\Models\Renter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;



class RenterRepository implements RenterRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {

        return Office::find($officeId)->RenterData;
    }

    public function create($data)
    {
        $rules =[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:9|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                'unique:users,id_number,', // Ensure ID number is unique, excluding the current user
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'name.string' => __('The name must be a string.'),
            'name.max' => __('The name may not be greater than :max characters.'),

            'email.required' => __('The email field is required.'),
            'email.string' => __('The email must be a string.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.max' => __('The email may not be greater than :max characters.'),
            'email.unique' => __('The email has already been taken.'),

            'phone.required' => __('The phone field is required.'),
            'phone.string' => __('The phone must be a string.'),
            'phone.max' => __('The phone may not be greater than :max characters.'),
            'phone.unique' => __('The phone has already been taken.'),

            'password.required' => __('The password field is required.'),
            'password.string' => __('The password must be a string.'),
            'password.min' => __('The password must be at least :min characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'id_number.required' => 'The ID number field is required.',
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
            'id_number.unique' => 'The ID number has already been taken.', // Custom message for unique constraint
        

        ];
        validator($data, $rules,$messages)->validate();


        $officeId = auth()->user()->UserOfficeData->id;
        $office = Office::find($officeId);

        $user = User::create([
            'is_renter' => 1,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'key_phone' => $data['key_phone'],
            'full_phone' => $data['full_phone'],
            'password' => Hash::make($data['password']),
            'id_number' => $data['id_number'],

        ]);

        $role = Role::firstOrCreate(['name' => 'Renter']);
        $user->assignRole($role);


        $renter = Renter::create([
            'user_id' => $user->id,
        ]);

        // $data['office_id'];
        // $user = User::create($data);
        // return Renter::create([
        //     'office_id' => $data['office_id'],
        //     'user_id'=> $user->id
        // ]);
        $office = Office::find($officeId);
        $office->RenterData()->attach($renter->id);
        return $renter;

    }

    function getRenterById($id)
    {
        return Renter::find($id);
    }

    // public function updateRenter($id, $data)
    // {
    //     $Renter = Renter::findOrFail($id);
    //     $Renter->update($data);
    //     return $Renter;
    // }
    public function updateRenter($id, $data)
{
    // Define validation rules
    $renter = Renter::findOrFail($id);

    $rules = [
        'name' => 'required|string|max:255',
       'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($renter->UserData->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:25',
            ],
            'full_phone' => [
                'required',
                'string',
                'max:25',
                Rule::unique('users')->ignore($renter->UserData->id),
            ],
    ];

    $messages = [
        'name.required' => __('The name field is required.'),
        'name.string' => __('The name must be a string.'),
        'name.max' => __('The name may not be greater than :max characters.'),

        'email.required' => __('The email field is required.'),
        'email.string' => __('The email must be a string.'),
        'email.email' => __('The email must be a valid email address.'),
        'email.max' => __('The email may not be greater than :max characters.'),
        'email.unique' => __('The email has already been taken.'),

        'phone.required' => __('The phone field is required.'),
        'phone.string' => __('The phone must be a string.'),
        'phone.max' => __('The phone may not be greater than :max characters.'),
        'phone.unique' => __('The phone has already been taken.'),

        'full_phone.required' => __('The full_phone field is required.'),
        'full_phone.string' => __('The full_phone must be a string.'),
        'full_phone.max' => __('The full_phone may not be greater than :max characters.'),
        'full_phone.unique' => __('The full_phone has already been taken.'),
    ];

    validator($data, $rules, $messages)->validate();

    $user = $renter->UserData;

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->key_phone = $data['key_phone'];
    $user->full_phone = $data['full_phone'];
    $user->phone = $data['phone'];

    $user->save();

    return $renter;
}


    public function deleteRenter($id)
    {
        return Renter::findOrFail($id)->delete();
    }
}