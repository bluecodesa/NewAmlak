<?php

namespace App\Services\ServiceProvider;

use App\Interfaces\ServiceProvider\SettingRepositoryInterface;
use App\Models\Office;
use App\Models\ServiceProvider;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingService
{
    protected $SettingRepositoryInterface;

    public function __construct(SettingRepositoryInterface $SettingRepositoryInterface)
    {
        $this->SettingRepositoryInterface = $SettingRepositoryInterface;
    }

    public function getSetting(ServiceProvider $serviceProvider)
    {

        return $this->SettingRepositoryInterface->getSetting($serviceProvider);

    }


    public function updateOffice(array $data, $id)
    {
        $request = request();

        $serviceProvider = User::findOrFail($id);

        // Update validation rules to handle unique constraint correctly
        $rules = [
            'name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($serviceProvider->id),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->ignore($serviceProvider->id),
                'max:25'
            ],
            'id_number' => [
                'nullable',
                'numeric',
                'digits:10',
                Rule::unique('users')->ignore($serviceProvider->id),
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
            'city_id' => 'required|exists:cities,id',
            'avatar' => 'file|nullable',
            'CRN' => [
                'required',
                Rule::unique('service_providers')->ignore($serviceProvider->UserServiceProviderData->id),
                'max:25'
            ],

        ];

        $messages = [
            'company_name.required' => __('The company name field is required.'),
            'company_email.required' => __('The email field is required.'),
            'company_email.email' => __('The email must be a valid email address.'),
            'company_email.unique' => __('The email has already been taken.'),
            'company_email.max' => __('The email may not be greater than :max characters.'),
            'city_id.required' => __('The city field is required.'),
            'city_id.exists' => __('The selected city is invalid.'),
            'company_logo.file' => __('The company logo must be a file.'),
            'CRN.required' => __('The CRN field is required.'),
            'CRN.unique' => __('The CRN has already been taken.'),
            'CRN.max' => __('The CRN may not be greater than :max characters.'),
            'company_number.required' => __('The Company mobile number field is required.'),
            'company_number.unique' => __('The Company mobile number has already been taken.'),
            'company_number.max' => __('The Company mobile number may not be greater than :max characters.'),
            'office_license.numeric' => __('The license number must be a number.'),
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
            'id_number.unique' => 'The ID number has already been taken.', // Cus

        ];

        $request->validate($rules, $messages);

        // Update the office data
        $serviceProvider->update([
            'CRN' => $request->CRN,
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_number' => $request->company_number,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'city_id' => $request->city_id,
            'company_logo' => $request['company_logo'] ?? null,
            'office_license' => $request->office_license ?? null,

        ]);

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $ext = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Offices/Logos/'), $ext);
            $serviceProvider->update(['company_logo' => '/Offices/Logos/' . $ext]);
        }

        return redirect()->route('Office.Setting.index')->withSuccess(__('Updated successfully.'));


    }

    public function updateProfileSetting(Request $request, $id)
    {
        // dd($request);
        $user = User::findOrFail($id);

        // Define validation rules
        $rules = [
            'name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                'max:25'
            ],
            'id_number' => [
                'nullable',
                'numeric',
                'digits:10',
                Rule::unique('users')->ignore($user->id),
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^7\d{9}$/', $value)) {
                        $fail(__('The National number must start with 7 and be exactly 10 digits long.'));
                    }
                },
            ],
        ];

        // Define custom error messages
        $messages = [
            'presenter_number.digits' => __('The mobile number must be 20 digits.'),
            'presenter_number.unique' => __('The mobile number has already been taken.'),
            'id_number.numeric' => __('The ID number must be a number.'),
            'phone.required' => __('The Company mobile number field is required.'),
            'phone.unique' => __('The Company mobile number has already been taken.'),
            'phone.max' => __('The Company mobile number may not be greater than :max characters.'),
            'id_number.required' => __('The ID number is required.'),
            'id_number.string' => __('The ID number must be a string.'),
            'id_number.max' => __('The ID number may not be greater than :max characters.'),
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Update the office data
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'email' => $request->email,
            'id_number' => $request->id_number,
            'avatar' => $request['avatar'] ?? null,


        ]);
        $serviceProviderId = auth()->user()->UserServiceProviderData->id;
        $serviceProvider = ServiceProvider::findOrFail($serviceProviderId);

        $serviceProvider->update([
            'CRN' => $request->CRN,
            'city_id' => $request->city_id,
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/ServicePoviders/Logos/'), $ext);
            $user->update(['avatar' => '/ServicePoviders/Logos/' . $ext]);
        }

        // Redirect with success message
        return redirect()->route('Office.Setting.index')->withSuccess(__('Profile settings updated successfully.'));
    }



    public function updatePassword(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        // Fetch the associated user
        $user = $office->userData;

        $rules = [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Define custom error messages
        $messages = [
            'current_password.required' => __('The current password field is required.'),
            'password.required' => __('The new password field is required.'),
            'password.min' => __('The new password must be at least 8 characters.'),
            'password.confirmed' => __('The new password confirmation does not match.'),
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('The current password is incorrect.')]);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect()->route('Office.Setting.index')->withSuccess(__('Password updated successfully.'));
    }


    public function getSettings()
    {
        // Fetch settings from the database
        $settings = Setting::first();

        // Return the settings data
        return $settings;
    }

}
