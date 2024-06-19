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





class HomeController extends Controller
{

    use MailSendCode;

    public function index(){

        $finder =auth()->user();
        $favorites = FavoriteUnit::where('finder_id', $finder->id)->get();
        $units = Unit::with('Unitfavorites')
            ->whereIn('id', $favorites->pluck('unit_id'))
            ->get();
        return view('Home.Property-Finder.index',  get_defined_vars());
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
        ];

        $messages = [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.unique' => __('The email has already been taken.'),
            'phone.required' => __('The mobile field is required.'),
            'phone.unique' => __('The mobile has already been taken.'),
            'avatar.image' => __('The broker logo must be an image.')
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
        $otp = mt_rand(100000, 999999);
        session(['otp' => $otp]);
        $this->MailSendCode($request->email, $otp);
        return response()->json(['message' => 'OTP sent successfully']);
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


public function registerPropertyFinder(Request $request)
{
    $name = $request->input('name');
    $email = $request->input('email_hidden');
    $password = Hash::make($request->input('password'));
    // Create Property Finder logic
    $propertyFinder = PropertyFinder::create([
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ]);
    return response()->json(['message' => 'Property Finder created successfully']);
}


}
