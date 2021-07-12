<?php

return [
    'binance' => [
        'api_url' => 'https://api.binance.com/',
        'api_url_1' => 'https://api1.binance.com/',
        'api_url_2' => 'https://api2.binance.com/',
        'api_url_3' => 'https://api3.binance.com/',
        'account' => [
            'vania' => [
                'api_key' => env('VANIA_BINANCE_API_KEY'),
                'secret_key' => env('VANIA_BINANCE_API_SECRET_KEY')
            ]
        ]
    ]
];
