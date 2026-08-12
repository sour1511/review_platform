<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'recaptcha' => [
        'key' => env('GOOGLE_RECAPTCHA_KEY'),
        'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
    ],

    'maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'brevo' => [
        'key' => env('BREVO_API_KEY'),
        // Brevo SMTP login email (account email shown in SMTP & API settings)
        'smtp_user' => env('BREVO_SMTP_USER', env('MAIL_USERNAME')),
        'smtp_host' => env('BREVO_SMTP_HOST', 'smtp-relay.brevo.com'),
        'smtp_port' => env('BREVO_SMTP_PORT', 587),
        'from_address' => env('MAIL_FROM_ADDRESS', 'info@quejasyelogios.com'),
        'from_name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Reviews')),
    ],

    'api' => [
        'key' => env('API_ACCESS_KEY'),
    ],

];
