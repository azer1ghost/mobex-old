<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'portmanat/callback',
        'paytr_997hdyysb/success',
        'paymes_hdyysb/request',
        'my-parcel/*',
    ];
}
