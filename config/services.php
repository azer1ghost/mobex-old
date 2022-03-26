<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe'    => [
        'model'  => App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'portmanat' => [
        'service_id' => env('PORTMANAT_SERVICE_ID'),
        'key'        => env('PORTMANAT_KEY'),
    ],
    'azerpost' => [
        'vendor_id' => env('AZERPOST_VENDOR_ID'),
        'api_key' => env('AZERPOST_API_KEY'),
        'secret' => env('AZERPOST_SECRET'),
        'in_baku_fee' => 0.32, // USD
        'out_baku_fee' => 0.38, // USD
    ],
];
