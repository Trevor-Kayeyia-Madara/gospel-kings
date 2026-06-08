<?php

return [
    'environment' => env('DARAJA_ENV', 'sandbox'),
    'consumer_key' => env('DARAJA_CONSUMER_KEY'),
    'consumer_secret' => env('DARAJA_CONSUMER_SECRET'),
    'business_short_code' => env('DARAJA_BUSINESS_SHORT_CODE', '174379'),
    'passkey' => env('DARAJA_PASSKEY'),
    'callback_url' => env('DARAJA_CALLBACK_URL', env('APP_URL').'/api/mpesa/callback'),
    'base_url' => env('DARAJA_ENV', 'sandbox') === 'production'
        ? 'https://api.safaricom.co.ke'
        : 'https://sandbox.safaricom.co.ke',
];
