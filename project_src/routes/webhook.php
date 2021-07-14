<?php
/*
 *
 */
$router->get('/', function () use ($router) {
    return 'Hello world';
});

$router->group(['prefix' => 'webhook'], function () use ($router) {
    $router->post('rfvs-signal', [
        'as'         => 'rfvs_signal',
        'uses'       => 'WebhookController@rfvs_signal'
    ]);
    $router->post('crypto-swing-bot', [
        'as'         => 'telegram_crypto_swing_bot_webhook',
        'uses'       => 'WebhookController@telegram_crypto_swing_bot_webhook'
    ]);
});