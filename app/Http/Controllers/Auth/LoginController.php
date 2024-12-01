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

    public function login(Request $request)
{
    $input = $request->all();

    $this->validate($request, [
        'user_name' => 'required',
        'password' => 'required',
    ]);

    $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

    // Check if the email exists in the database
    $userExists = User::where($fieldType, $input['user_name'])->exists();

    if (!$userExists) {
        $errors = [
            'user_name' => __('The provided data is incorrect.'),
        ];
        return back()->withInput()->withErrors($errors);
    }

    $credentials = array($fieldType => $input['user_name'], 'password' => $input['password']);

    if (auth()->attempt($credentials)) {
        return redirect()->route('Admin.home');
    } else {
        $errors = [];

        if (!filter_var($request->user_name, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = __('The provided data is incorrect.');
        } else {
            $errors['password'] = __('The provided password is incorrect.');
        }

        return back()->withInput()->withErrors($errors);
    }
}






    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
