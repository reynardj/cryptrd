<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['namespace' => 'Hammer'], function () use ($router) {
    $router->group(['prefix' => 'hammer'], function () use ($router) {
        $router->group(['middleware' => 'authPartner'], function () use ($router) {
            $router->post('send-otp-sms', [
                'as'   => 'send_otp_sms',
                'uses' => 'AuthController@send_otp_sms'
            ]);
        });
    });
});