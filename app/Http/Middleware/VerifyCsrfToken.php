<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $addHttpCookie = true;
    protected $except = [
        '*/Payment/*',
        '*/callback_payments/*',
        '*/return_payments/*',
        '*/callback_payments_package/*',
        '*/return_payments_package/*',
        '*/callback_payments_packageUpgarde/*',
    ];
}
