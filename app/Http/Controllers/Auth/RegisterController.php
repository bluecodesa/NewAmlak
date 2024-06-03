<?php

// // app/Http/Controllers/Auth/RegisterController.php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\RegisterRequest;
// use App\Services\UserService;
// use App\Http\Traits\ResponseController;

// class RegisterController extends Controller
// {
//     use ResponseController;

//     protected $userService;

//     public function __construct(UserService $userService)
//     {
//         $this->middleware('guest');
//         $this->userService = $userService;
//     }

//     public function create(RegisterRequest $request)
//     {
//         try {
//             $user = $this->userService->registerUser($request->validated());

//             return $this->sendSuccessResponse(['user' => $user], 'User registered successfully', 201);
//         } catch (\Exception $e) {
//             // Log the error if needed
//             return $this->sendErrorResponse('Failed to register user', 500);
//         }
//     }
// }


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        $code = random_int(100000, 999999);

        // Store the code in the session
        Session::put('verification_code', $code);
        Session::put('verification_email', $email);
dd($code);
        // Send the code via email
        Mail::raw("Your verification code is: $code", function ($message) use ($email) {
            $message->to($email)->subject('Verification Code');
        });

        return redirect()->back()->with('status', 'Verification code sent!');
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inputCode = $request->input('code');
        $sessionCode = Session::get('verification_code');

        if ($inputCode == $sessionCode) {
            Session::put('is_verified', true);
            return redirect()->back()->with('status', 'Code verified!');
        } else {
            return redirect()->back()->withErrors(['code' => 'Invalid verification code'])->withInput();
        }
    }

    public function completeRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Session::get('is_verified')) {
            return redirect()->back()->withErrors(['error' => 'Please verify your email first'])->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => Session::get('verification_email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ]);

        Session::forget('verification_code');
        Session::forget('verification_email');
        Session::forget('is_verified');

        return redirect()->route('home')->with('status', 'Registration complete!');
    }

}
