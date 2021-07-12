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
// USER FRONTEND
// *************

$router->group(['namespace' => 'Partner'], function () use ($router) {
    $router->group(['prefix' => 'partner'], function () use ($router) {
        $router->group(['middleware' => 'authPartner'], function () use ($router) {
            $router->get('promo', [
                'as'   => 'promo_list',
                'uses' => 'PromoController@promo_list'
            ]);

            $router->get('promo/top', [
                'as'   => 'top_promo',
                'uses' => 'PromoController@top_promo'
            ]);

            $router->get('promo/by-category', [
                'as'   => 'promo_list_by_categories',
                'uses' => 'PromoController@promo_list_by_categories'
            ]);

            $router->get('promo/{promo_slug}', [
                'as'   => 'promo_detail',
                'uses' => 'PromoController@promo_detail'
            ]);

            $router->get('place/popular', [
                'as'   => 'popular_places',
                'uses' => 'PromoController@popular_places'
            ]);
        });
    });
});