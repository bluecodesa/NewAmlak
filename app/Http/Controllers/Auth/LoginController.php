<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
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

    // public function login(Request $request)

    // {
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'user_name' => 'required',
    //         'password' => 'required',
    //     ]);
    //     $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
    //     if (auth()->attempt(array($fieldType => $input['user_name'], 'password' => $input['password']))) {
    //         return redirect()->route('Admin.home');
    //     } else {

    //         return back()->with('sorry', 'Email-Address And Password Are Wrong.');
    //     }


    // }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        if (auth()->attempt([$fieldType => $input['user_name'], 'password' => $input['password']])) {
            $user = Auth::user();
            $subscription = Subscription::where('office_id', $user->id)->orWhere('broker_id', $user->id)->first();

            if ($subscription && $subscription->status === 'pending') {
                return redirect()->route('Admin.home')->with('showPendingPaymentPopup', true);
            }

            return redirect()->route('Admin.home');
        } else {
            return back()->with('sorry', 'Email-Address And Password Are Wrong.');
        }
    }




    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
