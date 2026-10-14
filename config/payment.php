<?php
return [
    'epay' => [
        'api_url' => env('EPAY_API_URL', ''),
        'pid' => env('EPAY_PID', ''),
        'key' => env('EPAY_KEY', ''),
        'notify_url' => env('EPAY_NOTIFY_URL', ''),
        'return_url' => env('EPAY_RETURN_URL', ''),
    ],
    'currency' => env('PAYMENT_CURRENCY', 'CNY'),
];
