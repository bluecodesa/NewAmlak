<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\SettingRepositoryInterface;
use App\Models\Broker;
use App\Models\Gallery;
use App\Models\Setting;
use Illuminate\Validation\Rule;

class SettingService
{
    protected $brokerSettingRepository;

    public function __construct(SettingRepositoryInterface $brokerSettingRepository)
    {
        $this->brokerSettingRepository = $brokerSettingRepository;
    }

    public function getBrokerSettings(Broker $broker)
    {

        return $this->brokerSettingRepository->getBrokerSettings($broker);
    }

    public function updateBroker(array $data, $id)
    {
        $request = request();

        $broker = Broker::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($broker->user_id),
            ],
            'mobile' => 'required|digits:9|unique:brokers,mobile,' . $id,
            'city_id' => 'required|exists:cities,id',
            'license_date' => 'required',
            'broker_license' => 'required|numeric|unique:brokers,broker_license,' . $id,
            // 'password' => 'nullable|string|max:255|confirmed',
            'broker_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'id_number' => [
                'nullable',
                Rule::unique('brokers')->ignore($id),
            ],
        ];



        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'mobile.required' => __('The mobile field is required.'),
            'mobile.unique' => __('The mobile has already been taken.'),
            'mobile.digits' => __('The mobile must be 9 digits.'),
            'broker_license.required' => __('The broker_license field is required.'),
            'broker_license.numeric' => __('The broker_license field must be number.'),
            'broker_license.unique' => __('The broker_license has already been taken.'),
            // 'password.required' => __('The password field is required.'),
            'broker_logo.image' => __('The broker logo must be an image.'),
            'city_id.required' => 'The city field is required.',
            'city_id.exists' => 'The selected city is invalid.',
            'id_number.unique' => __('The ID number has already been taken.'),
            // 'password.confirmed' => __('The password confirmation does not match.'),


        ];
        $request->validate($rules, $messages);

        $broker->update([
            'broker_license' => $request->broker_license,
            'license_date' => $request->license_date,
            'mobile' => $request->mobile,
            'city_id' => $request->city_id,
            'id_number' => $request->id_number,
        ]);



        if ($request->hasFile('broker_logo')) {
            $file = $request->file('broker_logo');
            $ext = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Brokers/' . 'Logos/', $ext);
            $broker->update(['broker_logo' => '/Brokers/' . 'Logos/' . $ext]);
        }
        if ($broker->license_date > now()->format('Y-m-d')) {
            $broker->update(['license_validity' => 'valid']);
            // Gallery::where('broker_id', $broker->id)->first()->update(['gallery_status' => '1']);
        } else {
            $broker->update(['license_validity' => 'expired']);
            $check_gallary = Gallery::where('broker_id', $broker->id)->first();
            if ($check_gallary) {
                $check_gallary->update(['gallery_status' => '0']);
            }
        }


        $user = $broker->UserData();

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Check if $ext is defined and not empty
        if (isset($ext) && !empty($ext)) {
            // Construct the avatar path only if $ext is defined
            $userData['avatar'] = '/Brokers/Logos/' . $ext;
        }


        $user->update($userData);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }




        // return $this->brokerSettingRepository->updateBroker($data, $id);
        return redirect()->route('Broker.Setting.index')->withSuccess(__('Updated successfully.'));
    }

    public function getSettings()
    {
        // Fetch settings from the database
        $settings = Setting::first();

        // Return the settings data
        return $settings;
    }
}
