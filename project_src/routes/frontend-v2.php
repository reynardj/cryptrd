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

$router->group(['namespace' => 'V2'], function () use ($router) {

    $router->group(['prefix' => 'v2'], function () use ($router) {

        $router->post('test-erp', [
            'as'   => 'test_erp',
            'uses' => 'PromoController@test_erp'
        ]);

        $router->get('user-qr', [
            'middleware' => 'auth',
            'as'         => 'loyalty_user_qr',
            'uses'       => 'LoyaltyController@loyalty_user_qr'
        ]);

        // Temporary Promo Converter for Mobile Apps
        $router->get('promo/slug-convert/{promo_slug}', [
            'as'   => 'promo_slug_to_id',
            'uses' => 'PromoController@promo_slug_to_id'
        ]);

        $router->get('brand/slug-convert/{brand_slug}', [
            'as'   => 'brand_slug_to_id',
            'uses' => 'BrandController@brand_slug_to_id'
        ]);

        $router->get('outlet/slug-convert/{outlet_slug}', [
            'as'   => 'outlet_slug_to_id',
            'uses' => 'BrandController@outlet_slug_to_id'
        ]);

        $router->group(['prefix' => 'auth'], function () use ($router) {
            $router->post('signin-email', [
                'as'   => 'user_signin_email',
                'uses' => 'AuthController@user_signin_email'
            ]);

            $router->post('signup-email', [
                'as'   => 'user_signup_email',
                'uses' => 'AuthController@user_signup_email'
            ]);

            $router->post('signup-email-verify', [
                'as'   => 'user_signup_email_verify',
                'uses' => 'AuthController@user_signup_email_verify'
            ]);

            $router->post('signup-email-resend', [
                'as'   => 'user_signup_email_resend_code',
                'uses' => 'AuthController@user_signup_email_resend_code'
            ]);

            $router->post('signup-email-data', [
                'as'   => 'user_signup_email_fill_data',
                'uses' => 'AuthController@user_signup_email_fill_data'
            ]);

            $router->post('signin-phone', [
                'as'   => 'user_signin_phone',
                'uses' => 'AuthController@user_signin_phone'
            ]);

            $router->post('signup-phone-check', [
                'as'   => 'user_signup_phone_check',
                'uses' => 'AuthController@user_signup_phone_check'
            ]);

            $router->post('signup-phone-check-2', [
                'as'   => 'user_signup_phone_check_2',
                'uses' => 'AuthController@user_signup_phone_check_2'
            ]);

            $router->post('signup-phone', [
                'as'   => 'user_signup_phone',
                'uses' => 'AuthController@user_signup_phone'
            ]);

            $router->post('signup-phone-web', [
                'as'   => 'user_signup_phone_token',
                'uses' => 'AuthController@user_signup_phone_token'
            ]);

            $router->post('signup-phone-data', [
                'as'   => 'user_signup_phone_fill_data',
                'uses' => 'AuthController@user_signup_phone_fill_data'
            ]);

            $router->post('signin-social', [
                'as'   => 'user_signin_social',
                'uses' => 'AuthController@user_signin_social'
            ]);

            $router->post('signup-social-data', [
                'as'   => 'user_signup_social_fill_data',
                'uses' => 'AuthController@user_signup_social_fill_data'
            ]);

            $router->post('signup-social-line', [
                'as'   => 'user_signin_social_line',
                'uses' => 'AuthController@user_signin_social_line'
            ]);

            $router->post('forgot-password-email', [
                'as'   => 'user_forgot_password_email',
                'uses' => 'AuthController@user_forgot_password_email'
            ]);

            $router->post('forgot-password-email-verify', [
                'as'   => 'user_forgot_password_email_verify',
                'uses' => 'AuthController@user_forgot_password_email_verify'
            ]);

            $router->post('forgot-password-email-resend', [
                'as'   => 'user_forgot_password_email_resend_code',
                'uses' => 'AuthController@user_forgot_password_email_resend_code'
            ]);

            $router->post('forgot-password-email-change', [
                'as'   => 'user_forgot_password_email_change',
                'uses' => 'AuthController@user_forgot_password_email_change'
            ]);

            $router->post('forgot-password-phone-check', [
                'as'   => 'user_forgot_password_phone_check',
                'uses' => 'AuthController@user_forgot_password_phone_check'
            ]);

            $router->post('forgot-password-phone', [
                'as'   => 'user_forgot_password_phone',
                'uses' => 'AuthController@user_forgot_password_phone'
            ]);

            $router->post('forgot-password-phone-web', [
                'as'   => 'user_forgot_password_phone_token',
                'uses' => 'AuthController@user_forgot_password_phone_token'
            ]);

            $router->post('forgot-password-phone-change', [
                'as'   => 'user_forgot_password_phone_change',
                'uses' => 'AuthController@user_forgot_password_phone_change'
            ]);

            $router->get('phone-codes', [
                'as'   => 'phone_codes',
                'uses' => 'AuthController@phone_codes'
            ]);

            $router->post('signin-invite', [
                'middleware' => 'auth',
                'as'         => 'user_signin_invite',
                'uses'       => 'AuthController@user_signin_invite'
            ]);

            $router->post('signup-invite', [
                'as'   => 'user_signup_invite',
                'uses' => 'AuthController@user_signup_invite'
            ]);

            $router->post('signup-invite-check', [
                'as'   => 'user_signup_invite_check',
                'uses' => 'AuthController@user_signup_invite_check'
            ]);

            $router->post('signup-invite-data', [
                'as'   => 'user_signup_invite_fill_data',
                'uses' => 'AuthController@user_signup_invite_fill_data'
            ]);

            $router->get('mref-check', [
                'as'   => 'mref_check',
                'uses' => 'AuthController@mref_check'
            ]);
        });

        $router->group(['prefix' => 'account'], function () use ($router) {
            $router->get('/', [
                'middleware' => 'auth',
                'as'         => 'account_profile_all',
                'uses'       => 'AccountController@account_profile_all'
            ]);

            $router->get('profile', [
                'middleware' => 'auth',
                'as'         => 'account_profile_view',
                'uses'       => 'AccountController@account_profile_view'
            ]);

            $router->put('profile', [
                'middleware' => 'auth',
                'as'         => 'account_profile_edit',
                'uses'       => 'AccountController@account_profile_edit'
            ]);

            $router->get('email', [
                'middleware' => 'auth',
                'as'         => 'account_email_list',
                'uses'       => 'AccountController@account_email_list'
            ]);

            $router->post('email', [
                'middleware' => 'auth',
                'as'         => 'account_email_add',
                'uses'       => 'AccountController@account_email_add'
            ]);

            $router->post('email-resend', [
                'middleware' => 'auth',
                'as'         => 'account_email_resend_code',
                'uses'       => 'AccountController@account_email_resend_code'
            ]);

            $router->post('email-verify', [
                'middleware' => 'auth',
                'as'         => 'account_email_verify',
                'uses'       => 'AccountController@account_email_verify'
            ]);

            $router->put('email-primary', [
                'middleware' => 'auth',
                'as'         => 'account_email_set_primary',
                'uses'       => 'AccountController@account_email_set_primary'
            ]);

            $router->delete('email', [
                'middleware' => 'auth',
                'as'         => 'account_email_remove',
                'uses'       => 'AccountController@account_email_remove'
            ]);

            $router->get('phone', [
                'middleware' => 'auth',
                'as'         => 'account_phone_list',
                'uses'       => 'AccountController@account_phone_list'
            ]);

            $router->post('phone-check', [
                'middleware' => 'auth',
                'as'         => 'account_phone_check',
                'uses'       => 'AccountController@account_phone_check'
            ]);

            $router->post('phone', [
                'middleware' => 'auth',
                'as'         => 'account_phone_add',
                'uses'       => 'AccountController@account_phone_add'
            ]);

            $router->post('phone-web', [
                'middleware' => 'auth',
                'as'   => 'account_phone_add_token',
                'uses' => 'AuthController@account_phone_add_token'
            ]);

            $router->put('phone-primary', [
                'middleware' => 'auth',
                'as'         => 'account_phone_set_primary',
                'uses'       => 'AccountController@account_phone_set_primary'
            ]);

            $router->delete('phone', [
                'middleware' => 'auth',
                'as'         => 'account_phone_remove',
                'uses'       => 'AccountController@account_phone_remove'
            ]);

            $router->get('social', [
                'middleware' => 'auth',
                'as'         => 'account_social_list',
                'uses'       => 'AccountController@account_social_list'
            ]);

            $router->post('social', [
                'middleware' => 'auth',
                'as'         => 'account_social_connect',
                'uses'       => 'AccountController@account_social_connect'
            ]);

            $router->delete('social', [
                'middleware' => 'auth',
                'as'         => 'account_social_disconnect',
                'uses'       => 'AccountController@account_social_disconnect'
            ]);

            $router->put('password', [
                'middleware' => 'auth',
                'as'         => 'change_password',
                'uses'       => 'AccountController@change_password'
            ]);

            $router->delete('delete', [
                'middleware' => 'auth',
                'as'         => 'account_delete',
                'uses'       => 'AccountController@account_delete'
            ]);
        });

        $router->group(['prefix' => 'loyalty'], function () use ($router) {
            $router->get('/', [
                'middleware' => 'auth',
                'as'         => 'loyalty_list',
                'uses'       => 'LoyaltyController@loyalty_list'
            ]);

            $router->post('rate', [
                'middleware' => 'auth',
                'as'         => 'loyalty_rate_trx',
                'uses'       => 'LoyaltyController@loyalty_rate_trx'
            ]);

            $router->get('rate-pending', [
                'middleware' => 'auth',
                'as'         => 'loyalty_rate_trx_pending',
                'uses'       => 'LoyaltyController@loyalty_rate_trx_pending'
            ]);

            $router->post('mref', [
                'middleware' => 'auth',
                'as'         => 'loyalty_apply_referral',
                'uses'       => 'LoyaltyController@loyalty_apply_referral'
            ]);

            $router->get('{business_slug}/receh-code', [
                'middleware' => 'auth',
                'as'         => 'receh_code',
                'uses'       => 'LoyaltyController@receh_code'
            ]);

            $router->get('{business_slug}/receh', [
                'middleware' => 'auth',
                'as'         => 'loyalty_receh',
                'uses'       => 'LoyaltyController@loyalty_receh'
            ]);

            $router->get('{business_slug}/point', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point',
                'uses'       => 'LoyaltyController@loyalty_point'
            ]);

            $router->get('{business_slug}/point-redeemables', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem_item_list',
                'uses'       => 'LoyaltyController@loyalty_point_redeem_item_list'
            ]);

            $router->get('{business_slug}/point-redeemables/{reward_redemption_item_id}', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem_item_detail',
                'uses'       => 'LoyaltyController@loyalty_point_redeem_item_detail'
            ]);

            $router->post('{business_slug}/point-redeem', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem',
                'uses'       => 'LoyaltyController@loyalty_point_redeem'
            ]);

            $router->post('{business_slug}/point-redeem-use', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem_agent',
                'uses'       => 'LoyaltyController@loyalty_point_redeem_agent'
            ]);

            $router->get('{business_slug}/point-redeem', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem_history',
                'uses'       => 'LoyaltyController@loyalty_point_redeem_history'
            ]);

            $router->get('{business_slug}/point-redeem-pending', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem_pending',
                'uses'       => 'LoyaltyController@loyalty_point_redeem_pending'
            ]);

            $router->post('{business_slug}/point-redeem-qr', [
                'middleware' => 'auth',
                'as'         => 'loyalty_point_redeem_qr',
                'uses'       => 'LoyaltyController@loyalty_point_redeem_qr'
            ]);

            $router->get('{business_slug}/discount', [
                'middleware' => 'auth',
                'as'         => 'loyalty_discount',
                'uses'       => 'LoyaltyController@loyalty_discount'
            ]);

            $router->get('{business_slug}/discount-rules', [
                'middleware' => 'auth',
                'as'         => 'loyalty_discount_rules',
                'uses'       => 'LoyaltyController@loyalty_discount_rules'
            ]);

            $router->get('{business_slug}/outlet', [
                'middleware' => 'auth',
                'as'         => 'loyalty_outlet_list',
                'uses'       => 'LoyaltyController@loyalty_outlet_list'
            ]);

            $router->get('{business_slug}/referral', [
                'middleware' => 'auth',
                'as'         => 'loyalty_referral',
                'uses'       => 'LoyaltyController@loyalty_referral'
            ]);

            $router->get('{business_slug}', [
                'middleware' => 'auth',
                'as'         => 'loyalty_card',
                'uses'       => 'LoyaltyController@loyalty_card'
            ]);
        });

        // COUPON
        $router->group(['prefix' => 'coupon'], function () use ($router) {
            $router->get('/', [
                'middleware' => 'auth',
                'as' => 'coupon_list',
                'uses' => 'CouponController@coupon_list'
            ]);

            $router->post('/code-claim', [
                'middleware' => 'auth',
                'as' => 'coupon_code_claim',
                'uses' => 'CouponController@coupon_code_claim'
            ]);

            $router->get('{coupon_user_id}', [
                'middleware' => 'auth',
                'as' => 'coupon_view',
                'uses' => 'CouponController@coupon_view'
            ]);

            $router->get('{coupon_user_id}/open', [
                'middleware' => 'auth',
                'as' => 'coupon_open',
                'uses' => 'CouponController@coupon_open'
            ]);

            $router->post('{coupon_user_id}/use', [
                'middleware' => 'auth',
                'as' => 'coupon_use',
                'uses' => 'CouponController@coupon_use'
            ]);
        });

        $router->group(['prefix' => 'notification'], function () use ($router) {
            $router->get('/', [
                'middleware' => 'auth',
                'as'         => 'notification_list',
                'uses'       => 'NotificationController@notification_list'
            ]);

            $router->get('unread-count', [
                'middleware' => 'auth',
                'as'         => 'notification_unread_count',
                'uses'       => 'NotificationController@notification_unread_count'
            ]);

            $router->put('read-all', [
                'middleware' => 'auth',
                'as'         => 'notification_read_all',
                'uses'       => 'NotificationController@notification_read_all'
            ]);

            $router->put('open', [
                'middleware' => 'auth',
                'as'         => 'notification_open',
                'uses'       => 'NotificationController@notification_open'
            ]);

            $router->put('open-all', [
                'middleware' => 'auth',
                'as'         => 'notification_open_all',
                'uses'       => 'NotificationController@notification_open_all'
            ]);

            $router->post('test', [
                'middleware' => 'auth',
                'as'         => 'test_notif',
                'uses'       => 'NotificationController@test_notif'
            ]);
        });

        $router->group(['prefix' => 'app'], function () use ($router) {
            $router->get('rate', [
                'middleware' => 'auth',
                'as'         => 'user_app_rating_retrieve',
                'uses'       => 'AppController@user_app_rating_retrieve'
            ]);

            $router->post('rate', [
                'middleware' => 'auth',
                'as'         => 'user_app_rating_create',
                'uses'       => 'AppController@user_app_rating_create'
            ]);

            $router->post('device', [
                'as'   => 'store_user_device',
                'uses' => 'AppController@store_user_device'
            ]);

            $router->post('version-check', [
                'as'   => 'version_check',
                'uses' => 'AppController@version_check'
            ]);
        });

        $router->get('promo/saved', [
            'middleware' => 'auth',
            'as'         => 'get_saved_promo',
            'uses'       => 'PromoController@saved'
        ]);

        $router->group(['prefix' => 'promo'], function () use ($router) {
            $router->post('{promo_slug}/like', [
                'middleware' => 'auth',
                'as'         => 'promo_like',
                'uses'       => 'PromoController@promo_like'
            ]);

            $router->post('{promo_slug}/unlike', [
                'middleware' => 'auth',
                'as'         => 'promo_unlike',
                'uses'       => 'PromoController@promo_unlike'
            ]);

            $router->post('{promo_slug}/save', [
                'middleware' => 'auth',
                'as'         => 'promo_save',
                'uses'       => 'PromoController@promo_save'
            ]);

            $router->post('{promo_slug}/unsave', [
                'middleware' => 'auth',
                'as'         => 'promo_unsave',
                'uses'       => 'PromoController@promo_unsave'
            ]);
        });

        $router->group(['prefix' => 'brand'], function () use ($router) {
            $router->get('followed', [
                'middleware' => 'auth',
                'as'         => 'brand_followed_list',
                'uses'       => 'BrandController@brand_followed_list'
            ]);

            $router->post('{brand_slug}/follow', [
                'middleware' => 'auth',
                'as'         => 'brand_follow',
                'uses'       => 'BrandController@brand_follow'
            ]);

            $router->post('{brand_slug}/unfollow', [
                'middleware' => 'auth',
                'as'         => 'brand_unfollow',
                'uses'       => 'BrandController@brand_unfollow'
            ]);

            $router->get('{brand_slug}/coupon', [
                'middleware' => 'auth',
                'as'         => 'brand_coupons',
                'uses'       => 'BrandController@brand_coupons'
            ]);

            $router->get('{brand_slug}/loyalty', [
                'middleware' => 'auth',
                'as'         => 'brand_loyalties',
                'uses'       => 'BrandController@brand_loyalties'
            ]);
        });

        $router->group(['middleware' => ['platformCheck']], function () use ($router) {
            // PROMO
            $router->get('promo/saved', [
                'as'   => 'promo_list_by_categories',
                'uses' => 'PromoController@promo_list_by_categories'
            ]);

            $router->post('promo/save', [
                'as'    => 'promo_save_v1',
                'uses'  => 'PromoController@promo_save_v1'
            ]);

            $router->post('promo/unsave', [
                'as'    => 'promo_unsave_v1',
                'uses'  => 'PromoController@promo_unsave_v1'
            ]);

            $router->get('promo/saved-expired', [
                'as'   => 'promo_saved_expired',
                'uses' => 'PromoController@promo_saved_expired'
            ]);

            $router->get('promo/search', [
                'as'   => 'search_promo',
                'uses' => 'SearchController@search_promo'
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
                'as'   => 'get_promo_list',
                'uses' => 'PromoController@retrieve'
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

            $router->group(['prefix' => 'promo'], function () use ($router) {
                $router->get('/', [
                    'as'   => 'search_promo',
                    'uses' => 'SearchController@search_promo'
                ]);

                $router->get('top', [
                    'as'   => 'promo_top_list',
                    'uses' => 'PromoController@promo_top_list'
                ]);

                $router->get('newest', [
                    'as'   => 'promo_newest_list',
                    'uses' => 'PromoController@promo_newest_list'
                ]);

                $router->get('by-category', [
                    'as'   => 'promo_list_by_categories',
                    'uses' => 'PromoController@promo_list_by_categories'
                ]);

                $router->get('{promo_slug}', [
                    'as'   => 'promo_detail',
                    'uses' => 'PromoController@promo_detail'
                ]);

                $router->get('search/filter-data', [
                    'as'   => 'get_active_filters_data',
                    'uses' => 'SearchController@get_active_filters_data'
                ]);

                $router->get('search/filter-sort', [
                    'as'   => 'filter_sort',
                    'uses' => 'SearchController@filter_sort'
                ]);

                $router->get('search/filter-category', [
                    'as'   => 'filter_category',
                    'uses' => 'SearchController@filter_category'
                ]);

                $router->get('search/filter-brand', [
                    'as'   => 'filter_brand',
                    'uses' => 'SearchController@filter_brand'
                ]);

                $router->get('search/filter-location', [
                    'as'   => 'filter_location',
                    'uses' => 'SearchController@filter_location'
                ]);

                $router->get('search/filter-requirement', [
                    'as'   => 'filter_requirement',
                    'uses' => 'SearchController@filter_requirement'
                ]);
            });

            $router->group(['prefix' => 'brand'], function () use ($router) {
                // START! OLD VERSION TO SUPPORT MOBILE APP
                $router->get('promo/{brand_slug}', [
                    'as'   => 'brand_promo_list',
                    'uses' => 'BrandController@brand_promo_list'
                ]);

                $router->get('outlet/{brand_slug}', [
                    'as' => 'brand_outlet_list',
                    'uses' => 'BrandController@brand_outlet_list'
                ]);

                $router->get('info/{brand_slug}', [
                    'as' => 'brand_info',
                    'uses' => 'BrandController@brand_info'
                ]);
                // END! OLD VERSION TO SUPPORT MOBILE APP

                $router->get('{brand_slug}/promo', [
                    'as'   => 'brand_promo_list',
                    'uses' => 'BrandController@brand_promo_list'
                ]);

                $router->get('{brand_slug}/outlet', [
                    'as' => 'brand_outlet_list',
                    'uses' => 'BrandController@brand_outlet_list'
                ]);

                $router->get('{brand_slug}/info', [
                    'as' => 'brand_info',
                    'uses' => 'BrandController@brand_info'
                ]);

                $router->get('{brand_slug}', [
                    'as' => 'brand_details',
                    'uses' => 'BrandController@brand_details'
                ]);
            });

            // PLACE
            $router->get('place', ['as' => 'get_place_list', 'uses' => 'PlaceController@retrieve']);

            // PLACE
            $router->get('place/popular', [
                'as'   => 'place_popular_list',
                'uses' => 'PlaceController@place_popular_list'
            ]);

            $router->get('place/nearby', [
                'as'   => 'place_nearby_list',
                'uses' => 'PlaceController@place_nearby_list'
            ]);

            // CARD
            $router->get('card/publisher-by-type', [
                'as'   => 'card_publisher_list_by_type',
                'uses' => 'CardController@card_publisher_list_by_type'
            ]);

            $router->get('card/by-card-publisher', [
                'as'   => 'card_list_by_card_publisher',
                'uses' => 'CardController@card_list_by_card_publisher'
            ]);
        });
    });
});