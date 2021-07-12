<?php

$router->group(['prefix' => 'script'], function () use ($router) {
    $router->post('coupon/send-script', [
        'middleware' => 'auth',
        'as' => 'send_coupon_script',
        'uses' => 'ScriptController@send_coupon_script'
    ]);
    $router->post('wallet/top-up-script', [
        'middleware' => 'auth',
        'as' => 'wallet_top_up_script',
        'uses' => 'ScriptController@wallet_top_up_script'
    ]);
    $router->put('void-pos-sales-trx/{pos_sales_trx_head_id}', [
        'middleware' => 'auth',
        'as' => 'void_pos_sales_trx',
        'uses' => 'ScriptController@void_pos_sales_trx'
    ]);
    $router->get('testing', [
        'as' => 'testing',
        'uses' => 'ScriptController@testing'
    ]);
    $router->post('ingredient', [
        'as' => 'ingredient_create',
        'uses' => 'ScriptController@ingredient_create'
    ]);
    $router->put('calculate-user-reward-by-user-reward-id/{user_reward_id}', [
        'as'   => 'calculate_user_reward_by_user_reward_id',
        'uses' => 'ScriptController@calculate_user_reward_by_user_reward_id'
    ]);
    $router->put('calculate-user-reward/{reward_id}/{user_id}', [
        'as'   => 'calculate_user_reward',
        'uses' => 'ScriptController@calculate_user_reward'
    ]);
    $router->put('calculate-user-reward-per-reward-id/{reward_id}', [
        'as'   => 'calculate_user_reward_per_reward_id',
        'uses' => 'ScriptController@calculate_user_reward_per_reward_id'
    ]);
    $router->put('calculate-all-user-reward', [
        'as'   => 'calculate_all_user_reward',
        'uses' => 'ScriptController@calculate_all_user_reward'
    ]);
    $router->put('calculate-negative-user-reward', [
        'as'   => 'calculate_negative_user_reward',
        'uses' => 'ScriptController@calculate_negative_user_reward'
    ]);
    $router->put('reassign-user-point/{user_reward_id}', [
        'as'   => 'reassign_user_point',
        'uses' => 'ScriptController@reassign_user_point'
    ]);
    $router->put('reassign-user-point-by-reward-id/{reward_id}/{date}', [
        'as'   => 'reassign_user_point_by_reward_id',
        'uses' => 'ScriptController@reassign_user_point_by_reward_id'
    ]);
});