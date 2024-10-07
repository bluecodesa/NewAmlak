<?php

namespace App\Http\Traits\Email;

use App\Email\Admin\OwnerCredentials;
use Illuminate\Support\Facades\Mail;

trait MailOwnerCredentials
{
    public function MailOwnerCredentials($user, $password)
    {

        try {
            Mail::to($user->email)->send(mailable: new OwnerCredentials($user, $password));
        } catch (\Throwable $th) {
            // Handle exceptions if needed
        }
    }
}
