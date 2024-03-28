<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '*/Payment/*',
        '*/callback_payments/*',
        '*/return_payments/*',
        '*/callback_payments_package/*',
        '*/return_payments_package/*',
        '*/callback_payments_packageUpgarde/*',
    ];
}
