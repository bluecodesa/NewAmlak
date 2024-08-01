<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

//     public function login(Request $request)
// {
//     $input = $request->all();

//     $this->validate($request, [
//         'user_name' => 'required',
//         'password' => 'required',
//     ]);

//     $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

//     // Check if the email exists in the database
//     $userExists = User::where($fieldType, $input['user_name'])->exists();

//     if (!$userExists) {
//         $errors = [
//             'user_name' => __('The provided data is incorrect.'),
//         ];
//         return back()->withInput()->withErrors($errors);
//     }

//     $credentials = array($fieldType => $input['user_name'], 'password' => $input['password']);

//     if (auth()->attempt($credentials)) {
//         return redirect()->route('Admin.home');
//     } else {
//         $errors = [];

//         if (!filter_var($request->user_name, FILTER_VALIDATE_EMAIL)) {
//             $errors['email'] = __('The provided data is incorrect.');
//         } else {
//             $errors['password'] = __('The provided password is incorrect.');
//         }

//         return back()->withInput()->withErrors($errors);
//     }
// }


public function login(Request $request)
{
    $input = $request->all();

    $this->validate($request, [
        'user_name' => 'required',
        'password' => 'nullable',
        'otp' => 'nullable',
    ], [
        'user_name.required' => 'The email field is required.',
    ]);

    // $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
    $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'full_phone';


    $user = User::where($fieldType, $input['user_name'])->first();

    if (!$user && !empty($input['otp'])) {
        $sessionOtp = session('otp');
        if ($input['otp'] == $sessionOtp) {
            // return  redirect()->route('Home.auth.chooseAccount')->with('success', __('OTP is correct, but user does not exist. Please register.'));
            return view('auth.chooseAcount')->with('success', __('OTP is correct, but user does not exist. Please register.'));
        } else {
            return back()->withInput()->withErrors(['otp' => 'The provided OTP is incorrect.']);
        }
    }
    // If OTP is provided, verify it
    if (!empty($input['otp'])) {
        $sessionOtp = session('otp');
        if ($input['otp'] == $sessionOtp) {
            Auth::login($user);
            session()->forget('otp'); // clear OTP session
            return redirect()->route('Admin.home')->withSuccess('success', 'Logged in successfully with OTP');
        } else {
            return back()->withInput()->withErrors(['otp' => 'The provided OTP is incorrect.']);
        }
    }

    // If password is provided, verify it
    if (!empty($input['password'])) {
        $credentials = array($fieldType => $input['user_name'], 'password' => $input['password']);
        if (auth()->attempt($credentials)) {
            return redirect()->route('Admin.home')->withSuccess(__('Login successfully'));
        } else {
            return back()->withInput()->withErrors(['password' => __('The provided password is incorrect.')]);
        }
    }

    // If neither OTP nor password is provided
    return back()->withInput()->withErrors(['login' => 'Please provide either an OTP or a password to log in.']);
}




    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
