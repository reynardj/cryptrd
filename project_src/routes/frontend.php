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

$router->get('/', function () use ($router) {
    // return $router->version();
    return 'Welcome to Get Diskon API!<br/>API Master: Rolando (rolando@getdiskon.com)<br/><br/>&copy;2017 PT Inovasi Teknologi Kreatif, All rights reserved.';
});

$router->post('auth/sign-in-email', ['as' => 'sign_in_email', 'uses' => 'AuthController@sign_in_email']);

$router->post('auth/sign-up-email', function () use ($router) {
    // return $router->version();
    return ['error' => 'Please upgrade the app to the new version.'];
});

// $router->post('auth/sign-up-email', ['as' => 'sign_up_email', 'uses' => 'AuthController@sign_up_email']);

// *************
// USER FRONTEND
// *************


// PROMO

$router->get('promo/saved', [
    'middleware' => 'auth',
    'as'         => 'get_saved_promo',
    'uses'       => 'PromoController@saved'
]);

$router->post('promo/save', [
    'middleware' => 'auth',
    'as'         => 'save_promo',
    'uses'       => 'PromoController@save'
]);

$router->post('promo/unsave', [
    'middleware' => 'auth',
    'as'         => 'unsave_promo',
    'uses'       => 'PromoController@unsave'
]);

$router->post('promo/like', [
    'middleware' => 'auth',
    'as'         => 'like_promo',
    'uses'       => 'PromoController@like'
]);

$router->post('promo/unlike', [
    'middleware' => 'auth',
    'as'         => 'unlike_promo',
    'uses'       => 'PromoController@unlike'
]);


$router->post('brand/follow', ['middleware' => 'auth', 'as' => 'follow_brand', 'uses' => 'BrandController@follow']);
$router->post('brand/unfollow', ['middleware' => 'auth', 'as' => 'unfollow_brand', 'uses' => 'BrandController@unfollow']);




$router->group(['middleware' => ['platformCheck']], function () use ($router) {
    $router->get('docs', [
        'as'   => 'docs',
        'uses' => 'DocsController@docs'
    ]);

    $router->get('promo/search', [
        'as'   => 'search_promo',
        'uses' => 'SearchController@search_promo'
    ]);

    $router->get('promo/search/sort-type', [
        'as'   => 'search_promo_sort_types',
        'uses' => 'SearchController@search_promo_sort_types'
    ]);

    $router->get('promo/search/filter-category', [
        'as'   => 'filter_category',
        'uses' => 'SearchController@filter_category'
    ]);

    $router->get('promo/search/autocomplete/brand', [
        'as'   => 'autocomplete_brand',
        'uses' => 'SearchController@autocomplete_brand'
    ]);

    $router->get('promo/search/autocomplete/location', [
        'as'   => 'autocomplete_location',
        'uses' => 'SearchController@autocomplete_location'
    ]);

    $router->get('promo/search/autocomplete/bank_card', [
        'as'   => 'autocomplete_bank_card',
        'uses' => 'SearchController@autocomplete_bank_card'
    ]);

    $router->get('promo', [
        'middleware' => 'platformCheck',
        'as'   => 'get_promo_list',
        'uses' => 'PromoController@retrieve'
    ]);

    $router->get('promo/top', [
        'as'   => 'get_top_promotions',
        'uses' => 'PromoController@top'
    ]);

    $router->get('promo/home', [ // WILL BE REPLACED GRANULARLY
        'as'   => 'get_home_data',
        'uses' => 'PromoController@home'
    ]);

    $router->get('promo/searchable', [
        'as'   => 'get_searchable',
        'uses' => 'PromoController@searchable'
    ]);

    $router->get('promo/valid-outlets/{promo_id}', [
        'as'   => 'get_valid_outlets',
        'uses' => 'PromoController@get_valid_outlets'
    ]);

    $router->get('promo/bazaar/{promo_id}', [
        'as'   => 'get_bazaar_details',
        'uses' => 'PromoController@get_bazaar_details'
    ]);

    $router->get('promo/catalog/{promo_id}', [
        'as'   => 'get_catalog_details',
        'uses' => 'PromoController@get_catalog_details'
    ]);

    $router->get('promo/{id}', [
        'as'   => 'get_promo',
        'uses' => 'PromoController@show'
    ]);


    // PLACE
    $router->get('place', ['as' => 'get_place_list', 'uses' => 'PlaceController@retrieve']);
    $router->get('place/popular', ['as' => 'get_popular_places', 'uses' => 'PlaceController@retrieve']);

    $router->get('brand', ['as' => 'get_brand_list', 'uses' => 'BrandController@retrieve']);
    $router->get('brand/search', ['as' => 'get_brand_list', 'uses' => 'BrandController@retrieve']);
    $router->get('brand/promo/{brand_id}', ['as' => 'get_brand_promo_list', 'uses' => 'BrandController@get_brand_promo']);
    $router->get('brand/location/{brand_string}', ['as' => 'get_brand_locations', 'uses' => 'BrandController@get_brand_locations']);
    $router->get('brand/info/{brand_string}', ['as' => 'get_brand_info', 'uses' => 'BrandController@get_brand_info']);
    $router->get('brand/{brand_id}', ['as' => 'get_brand', 'uses' => 'BrandController@show']);
    $router->get('brand/{brand_id}/outlet', ['as' => 'get_brand_outlets', 'uses' => 'BrandController@get_outlets']);
});






$router->get('user/profile', ['middleware' => 'auth', 'as' => 'get_user_profile', 'uses' => 'UserController@get_profile']);
$router->post('user/profile', ['middleware' => 'auth', 'as' => 'set_user_profile', 'uses' => 'UserController@set_profile']);
$router->post('user/reset-password', ['as' => 'reset_password', 'uses' => 'UserController@reset_password']);
$router->post('user/change-password', ['middleware' => 'auth', 'as' => 'change_password', 'uses' => 'UserController@change_password']);

// REFERRAL
$router->get('referral', [
    'as' => 'get_referral_scheme',
    'uses' => 'LoyaltyController@get_referral_scheme'
]);
$router->post('referral', [
    'as' => 'apply_referral_scheme',
    'uses' => 'LoyaltyController@apply_referral_scheme'
]);

// LOYALTY
$router->get('loyalty/discount/{brand_string}', [
    'middleware' => 'auth',
    'as' => 'user_get_discount',
    'uses' => 'LoyaltyController@user_get_discount'
]);
$router->get('loyalty/point', [
    'middleware' => 'auth',
    'as' => 'user_get_points',
    'uses' => 'LoyaltyController@user_get_points'
]);
$router->get('loyalty/point/{brand_string}/amount', [
    'middleware' => 'auth',
    'as' => 'user_get_point_amount',
    'uses' => 'LoyaltyController@user_get_point_amount'
]);
$router->get('loyalty/point/{brand_string}/detail', [
    'middleware' => 'auth',
    'as' => 'user_get_point_details',
    'uses' => 'LoyaltyController@user_get_point_details'
]);
$router->get('loyalty/point/{brand_string}/transaction', [
    'middleware' => 'auth',
    'as' => 'user_get_point_transactions',
    'uses' => 'LoyaltyController@user_get_point_transactions'
]);

// WALLET
$router->get('wallet', [
    'middleware' => 'auth',
    'as' => 'user_get_wallets',
    'uses' => 'LoyaltyController@user_get_wallets'
]);
$router->get('wallet/{brand_string}/amount', [
    'middleware' => 'auth',
    'as' => 'user_get_wallet_amount',
    'uses' => 'LoyaltyController@user_get_wallet_amount'
]);
$router->get('wallet/{brand_string}/transaction', [
    'middleware' => 'auth',
    'as' => 'user_get_wallet_transactions',
    'uses' => 'LoyaltyController@user_get_wallet_transactions'
]);

// COUPON
$router->get('coupon', [
    'middleware' => 'auth',
    'as' => 'user_get_coupons',
    'uses' => 'LoyaltyController@user_get_coupons'
]);
$router->get('coupon/{brand_string}', [
    'middleware' => 'auth',
    'as' => 'user_get_coupon',
    'uses' => 'LoyaltyController@user_get_coupon'
]);

// ***************
// MERCHANT OFFICE
// ***************

// OTHERS
$router->get('country-dial-code', [
    'as'   => 'get_country_dial_codes',
    'uses' => 'GeneralController@get_country_dial_codes'
]);
