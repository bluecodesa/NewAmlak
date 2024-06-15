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

    public function updateRenter($id, $data)
    {
        $Renter = Renter::findOrFail($id);
        $Renter->update($data);
        return $Renter;
    }

    public function deleteRenter($id)
    {
        return Renter::findOrFail($id)->delete();
    }
}
