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


// *************
// USER FRONTEND V3
// *************

$router->group([
    'namespace' => 'Frontend\V3',
    'prefix' => 'v3'
], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('signing', [
            'as' => 'signing',
            'uses' => 'AuthController@signing'
        ]);

        $router->post('sign-up', [
            'as' => 'sign_up',
            'uses' => 'AuthController@sign_up'
        ]);

        $router->post('sign-up-resend-code', [
            'as' => 'sign_up_resend_code',
            'uses' => 'AuthController@sign_up_resend_code'
        ]);

        $router->post('sign-up-verify-code', [
            'as' => 'sign_up_verify_code',
            'uses' => 'AuthController@sign_up_verify_code'
        ]);

        $router->post('sign-up-init-profile', [
            'as' => 'sign_up_init_profile',
            'uses' => 'AuthController@sign_up_init_profile'
        ]);

        $router->post('sign-in', [
            'as' => 'sign_in',
            'uses' => 'AuthController@sign_in'
        ]);

        $router->post('sign-in-resend-code', [
            'as' => 'sign_in_resend_code',
            'uses' => 'AuthController@sign_in_resend_code'
        ]);

        $router->post('sign-in-verify-code', [
            'as' => 'sign_in_verify_code',
            'uses' => 'AuthController@sign_in_verify_code'
        ]);

        $router->post('forgot-password', [
            'as' => 'forgot_password',
            'uses' => 'AuthController@forgot_password'
        ]);

        $router->post('forgot-password-resend-code', [
            'as' => 'forgot_password_resend_code',
            'uses' => 'AuthController@forgot_password_resend_code'
        ]);

        $router->post('forgot-password-verify-code', [
            'as' => 'forgot_password_verify_code',
            'uses' => 'AuthController@forgot_password_verify_code'
        ]);

        $router->post('forgot-change-password', [
            'as' => 'forgot_change_password',
            'uses' => 'AuthController@forgot_change_password'
        ]);

        $router->post('delete-account-buat-ivan', [
            'as' => 'delete_account',
            'uses' => 'AuthController@delete_account'
        ]);

//         $router->post('testing', [
//            'as' => 'testing',
//            'uses' => 'AuthController@testing'
//        ]);
    });
});