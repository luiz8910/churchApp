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
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '359134241126376',
        'client_secret' => '347f5ff94d6277f6a806955cf051b0fa',
        'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],

    'linkedin' => [
        'client_id' => '786yyi22axk8gc',
        'client_secret' => 'K76rm0lANtIDO0Oj',
        'redirect' => 'http://localhost:8000/auth/linkedin/callback',
    ],

    'google' => [
        'client_id' => '453342020267-27prfvbe7p04cgcg9uj5r32dgci6o2q9.apps.googleusercontent.com',
        'client_secret' => 'mqy1Ho5DLRwbl3lV70QVEPiY',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ]

];
