<?php

return [
    'telegram' => [
        'max_message_length' => 4096,
        'default_chat_id' => env('TELEGRAM_DEFAULT_CHAT_ID'),
        'api_url' => 'https://api.telegram.org/',
        'allowed_chat_ids' => [
            env('RTYU_CHAT_ID')
        ],
        'bot' => [
            'crypto_swing_bot' => [
                'token' => env('TELEGRAM_CRYPTO_SWING_BOT_TOKEN')
            ]
        ],
        'send_message_endpoint' => 'https://api.telegram.org/bot' . env('TELEGRAM_CRYPTO_SWING_BOT_TOKEN') . '/sendMessage'
    ]
];
