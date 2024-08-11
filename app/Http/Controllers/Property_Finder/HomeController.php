<?php

namespace App\Http\Controllers\Property_Finder;

use App\Http\Controllers\Controller;
use App\Models\FavoriteUnit;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Http\Traits\Email\MailSendCode;
use  App\Email\Admin\SendOtpMail;
use App\Models\RealEstateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewPropertyFinderNotification;
use App\Services\Admin\DistrictService;




class HomeController extends Controller
{


    use MailSendCode;
    protected $districtService;

    public function __construct(DistrictService $districtService)
    {

        $this->districtService = $districtService;

    }

    public function index()
    {
        $finder = auth()->user();
        if ($finder->is_renter) {
            $finder->assignRole('Renter');
        } elseif ($finder->is_property_finder) {
            $finder->assignRole('Property-Finder');
        }

        $favorites = FavoriteUnit::where('finder_id', $finder->id)->get();
        $units = Unit::with('Unitfavorites')
            ->whereIn('id', $favorites->pluck('unit_id'))
            ->get();
            $user = auth()->user();
            // $requests = RealEstateRequest::where('user_id', $user->id)->get();

            $requests = RealEstateRequest::withCount(['requestStatuses as views_count' => function ($query) {
                $query->whereNotNull('read_by');
            }])->where('user_id', $user->id)->get();

            $count = 0;

                        // $requests = RealEstateRequest::where('user_id', $user->id)
            // ->withCount(['requestStatuses as status_count_3' => function ($query) {
            //     $query->where('request_status_id', 3);
            // }, 'requestStatuses as status_count_8' => function ($query) {
            //     $query->where('request_status_id', 8);
            // }])
            // ->get();

//             foreach($requests as $request){
//                 foreach($request->requestStatuses as $status);{
//                     if ($status->interestType && $status->interestType->show_for_realEaste === 0) {
// }
//         }
//     }
//     dd($status->interestType->name);

        return view('Home.Property-Finder.index', get_defined_vars());
    }

    public function create(){

    }

    public function show($id){

    }

    public function updatePropertyFinder(Request $request, $id)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'key_phone' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'id_number' => [
                'required',
                'numeric',
                'digits:10',
                'unique:users,id_number,' . $id, // Ensure ID number is unique, excluding the current user
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[12]\d{9}$/', $value)) {
                        $fail('The ID number must start with 1 or 2 and be exactly 10 digits long.');
                    }
                },
            ],
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'phone.required' => __('The mobile field is required.'),
            'phone.unique' => __('The mobile has already been taken.'),
            'avatar.image' => __('The Image logo must be an image.'),
            'id_number.required' => 'The ID number field is required.',
            'id_number.numeric' => 'The ID number must be a number.',
            'id_number.digits' => 'The ID number must be exactly 10 digits long.',
            'id_number.unique' => 'The ID number has already been taken.', // Custom message for unique constraint
        ];

        $request->validate($rules, $messages);

        $finder = User::findOrFail($id);
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($finder->avatar) {
                $oldAvatarPath = public_path($finder->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $file = $request->file('avatar');
            $ext = uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
            $finder->avatar = '/PropertyFounder/' . 'Logos/' . $ext;
        }

            $finder->name = $request->name;
            $finder->email = $request->email;
            $finder->phone = $request->phone;
            $finder->id_number = $request->id_number;
            $finder->key_phone = $request->key_phone;
            $finder->full_phone = $request->key_phone . $request->phone;

            $finder->save();

        return redirect()->route('PropertyFinder.home')->withSuccess(__('Property Finder updated successfully.'));
    }

    public function updatePassword(Request $request, $id)
    {
     $user = User::findOrFail($id);


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
        return redirect()->route('PropertyFinder.home')->withSuccess(__('Password updated successfully.'));
    }

    // public function updatePassword(Request $request, $id)
    // {
    //     $rules = [
    //         'password' => 'required|string|min:8|confirmed',
    //     ];

    //     $messages = [
    //         'password.required' => __('The new password field is required.'),
    //         'password.min' => __('The new password must be at least 8 characters.'),
    //         'password.confirmed' => __('The new password confirmation does not match.'),
    //     ];

    //     $request->validate($rules, $messages);

    //     $user = User::findOrFail($id);

    //     if (!Hash::check($request->password, $user->password)) {
    //         return back()->withErrors(['password' => __('The current password is incorrect.')]);
    //     }

    //     $user->password = bcrypt($request->new_password);
    //     $user->save();

    //     return redirect()->route('PropertyFinder.home')->withSuccess(__('Password updated successfully.'));
    // }



    public function sendOtp(Request $request)
    {
        $email = $request->input('email');

        $userExists = User::where('email', $email)->exists();

        if (!$userExists) {
            $otp = mt_rand(100000, 999999);
            // $otp = 555555; // Static OTP for testing
            session(['otp' => $otp]);
            $this->MailSendCode($request->email, $otp);
            return response()->json(['message' => 'OTP sent successfully']);
        } else {
            return response()->json(['message' => 'This email is already registered.'], 400);
        }
    }


    public function verifyOtp(Request $request)
{
    $email = $request->input('email');
    $otp = $request->input('otp');
    if ($otp == session('otp')) {
        return response()->json(['message' => 'OTP verified']);
    } else {
        return response()->json(['error' => 'Invalid OTP'], 422);
    }
}

public function resendOtp(Request $request)
{
    $email = $request->input('email');
    $otp = session('otp');
    $this->MailSendCode($request->email, $otp);
    return response()->json(['message' => 'OTP resent successfully']);
}


// public function registerPropertyFinder(Request $request)
// {
//     $name = $request->input('name');
//     $email = $request->input('email_hidden');
//     $password = Hash::make($request->input('password'));
//     // Create Property Finder logic
//     $propertyFinder = PropertyFinder::create([
//         'name' => $name,
//         'email' => $email,
//         'password' => $password,
//     ]);
//     return response()->json(['message' => 'Property Finder created successfully']);
// }


public function registerPropertyFinder(Request $request)
{

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        // 'phone' => [
        //     'required',
        //     'max:25'
        // ],
        // 'full_phone' => [
        //     'required',
        //     Rule::unique('users'),
        //     'max:25'
        // ],
        'password' => 'required|string|max:255|confirmed',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ];

    $messages = [
        'name.required' => __('The name field is required.'),
        'email.required' => __('The email field is required.'),
        'email.unique' => __('The email has already been taken.'),
        'full_phone.required' => __('The mobile field is required.'),
        'full_phone.unique' => __('The mobile has already been taken.'),
        'password.required' => __('The password field is required.'),
        'password.confirmed' => __('The password confirmation does not match.'),
        'avatar.image' => __('The broker logo must be an image.')
    ];

    $request->validate($rules, $messages);

    $request_data = [];

    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $ext  =  uniqid() . '.' . $file->clientExtension();
        $file->move(public_path() . '/PropertyFounder/' . 'Logos/', $ext);
        $request_data['avatar'] = '/PropertyFounder/' . 'Logos/' . $ext;
    }

    $user = User::create([
        'is_property_finder' => 1,
        'name' => $request->name,
        'phone' => $request->phone ?? null,
        'key_phone' => $request->key_phone ?? null,
        'full_phone' => $request->full_phone ?? null,
        'email' => $request->email,
        'user_name' => uniqid(),
        'password' => bcrypt($request->password),
        'avatar' => $request_data['avatar'] ?? null,
    ]);

    $this->notifyAdmins2($user);
    auth()->loginUsingId($user->id);

    return response()->json([
        'message' => 'Property Finder registered successfully.',
        'redirect' => route('PropertyFinder.home')
    ]);

    // return response()->json(['message' => 'Property Finder created successfully']);
}

protected function notifyAdmins2(User $user)
{
    $admins = User::where('is_admin', true)->get();
    foreach ($admins as $admin) {
        Notification::send($admin, new NewPropertyFinderNotification($user));
    }
}

public function GetDistrictsByCity($id)
{
    // $districts = District::where('city_id', $id)->get();
    $districts = $this->districtService->getDistrictsByCity($id);

    return view('Admin.settings.Region.inc._district', get_defined_vars());
}

}
