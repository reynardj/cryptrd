<?php

return [
    'telegram' => [
        'max_message_length' => 4096,
        'default_chat_id' => '410223509',
        'api_url' => 'https://api.telegram.org/',
        'bot' => [
            'gdbusinessbot' => [
                'token' => env('TELEGRAM_CRYPTO_SWING_BOT_TOKEN')
            ]
        ],
        'send_message_endpoint' => 'https://api.telegram.org/bot' . env('TELEGRAM_CRYPTO_SWING_BOT_TOKEN') . '/sendMessage'
    ]
];
