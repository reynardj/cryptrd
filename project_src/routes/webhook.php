<?php
$router->get('/', function () use ($router) {
    return 'Hello world';
});

$router->group(['prefix' => 'webhook'], function () use ($router) {
    $router->post('adsmedia', [
        'as'         => 'adsmedia',
        'uses'       => 'WebhookController@adsmedia'
    ]);
    $router->post('smsviro', [
        'as'         => 'smsviro',
        'uses'       => 'WebhookController@smsviro'
    ]);
    $router->post('twilio', [
        'as'         => 'twilio',
        'uses'       => 'WebhookController@twilio'
    ]);
    $router->post('rfvs-signal', [
        'as'         => 'rfvs_signal',
        'uses'       => 'WebhookController@rfvs_signal'
    ]);
});