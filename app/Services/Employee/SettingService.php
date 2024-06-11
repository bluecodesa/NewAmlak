<?php

namespace App\Services\Employee;

use App\Interfaces\Employee\SettingRepositoryInterface;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingService
{
    protected $officeSettingRepository;

    public function __construct(SettingRepositoryInterface $officeSettingRepository)
    {
        $this->officeSettingRepository = $officeSettingRepository;
    }

    public function getofficeSettings(Office $office)
    {

        return $this->officeSettingRepository->getofficeSettings($office);

    }

    public function updateOffice(array $data, $id)
    {
        $request = request();

        $office = Office::findOrFail($id);

        // Update validation rules to handle unique constraint correctly
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($office->user_id),
            ],
            'city_id' => 'required|exists:cities,id',
            'company_logo' => 'file|nullable',
            'CRN' => [
                'required',
                Rule::unique('offices')->ignore($id),
                'max:25'
            ],
            'phone' => [
                'required',
                Rule::unique('users')->ignore($office->user_id),
                'max:25'
            ],
            'office_license' => 'nullable|numeric',

        ];

        $messages = [
            'name.required' => __('The company name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.unique' => __('The email has already been taken.'),
            'email.max' => __('The email may not be greater than :max characters.'),
            'city_id.required' => __('The city field is required.'),
            'city_id.exists' => __('The selected city is invalid.'),
            'company_logo.file' => __('The company logo must be a file.'),
            'CRN.required' => __('The CRN field is required.'),
            'CRN.unique' => __('The CRN has already been taken.'),
            'CRN.max' => __('The CRN may not be greater than :max characters.'),
            'phone.required' => __('The Company mobile number field is required.'),
            'phone.unique' => __('The Company mobile number has already been taken.'),
            'phone.max' => __('The Company mobile number may not be greater than :max characters.'),
        ];

        $request->validate($rules, $messages);

        // Update the office data
        $office->update([
            'CRN' => $request->CRN,
            'company_name' => $request->name,
            'city_id' => $request->city_id,
            'company_logo' => $request['company_logo'] ?? null,
        ]);

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $ext = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/Offices/Logos/'), $ext);
            $office->update(['company_logo' => '/Offices/Logos/' . $ext]);
        }

        $user = $office->userData();

        $userData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'email' => $request->email,
        ];
        $office->update([
            'office_license' => $request->office_license,
        ]);

        // Update user avatar if new logo is uploaded
        if (isset($ext) && !empty($ext)) {
            $userData['avatar'] = '/Offices/Logos/' . $ext;
        }

        $user->update($userData);

        // Redirect with success message
        return redirect()->route('Office.Setting.index')->withSuccess(__('Updated successfully.'));


    }

  
    public function updateProfileSetting(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee->user_id),
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
            ],
            'full_phone' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($employee->user_id),
            ],
            'id_number' => 'required|numeric',

        ], [
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
            'full_phone.unique' => __('The phone has already been taken.'),
            'id_number.numeric' => __('The ID number must be a number.'),
            'id_number.required' => __('The ID number field is required.'),


         
        ]);

        $user = $employee->userData();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'key_phone' => $request->key_phone,
            'full_phone' => $request->full_phone,
            'id_number' => $request->id_number,

        ]);

        return redirect()->route('Employee.Setting.index')->withSuccess(__('Profile settings updated successfully.'));
    }


    public function updatePassword(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
    
        // Fetch the associated user
        $user = $employee->userData;
    
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
        return redirect()->route('Employee.Setting.index')->withSuccess(__('Password updated successfully.'));
    }
    

    public function getSettings()
    {
        // Fetch settings from the database
        $settings = Setting::first();

        // Return the settings data
        return $settings;
    }

}
