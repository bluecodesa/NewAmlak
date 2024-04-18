<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\Email\MailForgotPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;
use Hash;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    use MailForgotPassword;



//////////////////////////////////////////////////


        public function showForgetPasswordForm()
        {
            $setting =   Setting::first();

           return view('auth.reset_password.recover_password');
        }


        public function submitForgetPasswordForm(Request $request)
        {
            $request->validate([
                'email' => 'required|email|exists:users',
            ], [
                'email.exists' => 'The email address is not registered.', // Custom message for email not found
            ]);


            // Check if a password reset entry already exists for the provided email
            $existingReset = DB::table('password_resets')
                                ->where('email', $request->email)
                                ->first();


            if ($existingReset) {
                // If a reset entry already exists, update its token and created_at timestamp
                $token = Str::random(64);
                DB::table('password_resets')
                    ->where('email', $request->email)
                    ->update([
                        'token' => $token,
                        'created_at' => Carbon::now()
                    ]);
            } else {
                // If no reset entry exists, insert a new record
                $token = Str::random(64);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
            }

            $code = str_pad(mt_rand(0, 9999), 6, '0', STR_PAD_LEFT);
            $expiry = Carbon::now()->addMinutes(1);

            $currentTime = Carbon::now();
            $expiryTime = Carbon::parse($expiry);
            $remainingTime = $expiryTime->diffInSeconds($currentTime);

            // Store the code in the cache with the email as the key, set to expire in 30 minutes
            Cache::put('password_reset_code_' . $request->email, $code, $expiry);

            // Mail::send('auth.reset_password.password_code', ['code' => $code], function ($message) use ($request) {
            //     $message->to($request->email);
            //     $message->subject('Reset Password Code');
            // });


            $this->MailForgotPassword($request->email, $code);


            return view('auth.reset_password.confirm')->with([
                'message' => 'We have e-mailed your password reset code!',
                'email' => $request->email,
                'token' => $token,
                'remainingTime' => $remainingTime

            ]);
        }


public function submitCodeForm(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users',
        'code' => 'required|digits:6',
    ]);

    $cachedCode = Cache::get('password_reset_code_' . $request->email);

    if ($cachedCode && $cachedCode === $request->code) {
        return view('auth.reset_password.reset')->with([
            'email' => $request->email,
            'token' => $request->token,
        ]);
    } else {
        return view('auth.reset_password.confirm')->with([
            'email' => $request->email,
            'token' => $request->token,
            'code' => 'Invalid code. Please try again.',
        ]);
    }
}





        public function submitResetPasswordForm(Request $request)
        {
            // dd($request);
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|confirmed',
                'password_confirmation' => 'required'
            ]);

            if ($validator->fails()) {
                return view('auth.reset_password.reset')->withErrors($validator)->with([
                    'email' => $request->email,
                    'token' => $request->token,
                ]);
            }

            $token = $request->token;

            $updatePassword = DB::table('password_resets')
                                ->where([
                                  'email' => $request->email,
                                  'token' => $request->token
                                ])
                                ->first();


            if(!$updatePassword){
                return back()->withInput()->with('error', 'Invalid token!');

            }

            $user = User::where('email', $request->email)
                        ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect('/login')->with('message', 'Your password has been changed!');
        }


        // public function showresetform()
        // {
        //     $setting =   Setting::first();

        //    return view('auth.reset_password.confirm');
        // }



        public function sendNewCode(Request $request)
        {
            $email = $request->email; // Get the email from the request

            // Make sure the email is not null
            if (!$email) {
                return back()->with('error', 'Email is missing.');
            }

            // Generate a new token
            $token = Str::random(64);

            // Generate a new code
            $code = str_pad(mt_rand(0, 9999), 6, '0', STR_PAD_LEFT);

            // Calculate expiry time
            $expiry = Carbon::now()->addMinutes(1);

            // Calculate remaining time
            $currentTime = Carbon::now();
            $expiryTime = Carbon::parse($expiry);
            $remainingTime = $expiryTime->diffInSeconds($currentTime);

            // Store the new code in the cache with the email as the key
            Cache::put('password_reset_code_' . $email, $code, $expiry);

            // Send email notification with the new code
            $this->MailForgotPassword($email, $code);

            return view('auth.reset_password.confirm')->with([
                'message' => 'New code has been sent successfully!',
                'email' => $email,
                'token' => $token,
                'remainingTime' => $remainingTime
            ]);
        }


}
