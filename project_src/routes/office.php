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

// *******
// OFFICE
// *******
$router->group(['namespace' => 'Office'], function () use ($router) {
    $router->group(['prefix' => 'office'], function () use ($router) {

        // ADMIN AUTH
        $router->post('auth/sign-in', [
            'as'   => 'admin_sign_in',
            'uses' => 'AuthController@admin_sign_in'
        ]);
        $router->get('auth/sign-out', [
            'as'   => 'admin_sign_out',
            'uses' => 'AuthController@admin_sign_out'
        ]);

        // BUSINESS
        $router->get('business', [
            'middleware' => 'auth',
            'as'   => 'business_list',
            'uses' => 'BusinessController@business_list'
        ]);
        $router->get('retail-business', [
            'middleware' => 'auth',
            'as'   => 'retail_business_list',
            'uses' => 'BusinessController@retail_business_list'
        ]);
        $router->get('foodcourt-business', [
            'middleware' => 'auth',
            'as'   => 'foodcourt_business_list',
            'uses' => 'BusinessController@foodcourt_business_list'
        ]);
        $router->post('business', [
            'middleware' => 'auth',
            'as'   => 'business_create',
            'uses' => 'BusinessController@business_create'
        ]);
        $router->post('business/{business_id}', [
            'middleware' => 'auth',
            'as'   => 'business_edit',
            'uses' => 'BusinessController@business_edit'
        ]);
        $router->get('business/{business_id}', [
            'middleware' => 'auth',
            'as'   => 'get_business',
            'uses' => 'BusinessController@get_business'
        ]);
        $router->post('business/email-resend/{business_id}', [
            'middleware' => 'auth',
            'as'   => 'resend_email',
            'uses' => 'BusinessController@resend_email'
        ]);

        // BUSINESS SETTING
        $router->get('business-settings/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_business_settings',
            'uses'       => 'BusinessController@get_business_settings'
        ]);
        $router->post('business-settings', [
            'middleware' => 'auth',
            'as'         => 'set_business_settings',
            'uses'       => 'BusinessController@set_business_settings'
        ]);

        // BUSINESS PROFILE
        $router->get('business-profile', [
            'middleware' => 'auth',
            'as'         => 'business_profile_list',
            'uses'       => 'BusinessController@business_profile_list'
        ]);
        $router->get('business-profile/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_business_profile',
            'uses'       => 'BusinessController@get_business_profile'
        ]);
        $router->post('business-profile/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'set_business_profile',
            'uses'       => 'BusinessController@set_business_profile'
        ]);

        // SUBSCRIPTION
        $router->get('business-subscription', [
            'middleware' => 'auth',
            'as'   => 'business_subscription_list',
            'uses' => 'BusinessController@business_subscription_list'
        ]);
        $router->post('business-subscription/{business_subscription_id}', [
            'middleware' => 'auth',
            'as'   => 'business_subscription_edit',
            'uses' => 'BusinessController@business_subscription_edit'
        ]);
        $router->get('business-subscription/{business_subscription_id}', [
            'middleware' => 'auth',
            'as'   => 'business_subscription_view',
            'uses' => 'BusinessController@business_subscription_view'
        ]);

        // BUSINESS USER
        $router->get('user', [
            'middleware' => 'auth',
            'as'         => 'business_user_list',
            'uses'       => 'BusinessUserController@business_user_list'
        ]);
        $router->get('user/{business_user_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_view',
            'uses'       => 'BusinessUserController@business_user_view'
        ]);
        $router->post('user', [
            'middleware' => 'auth',
            'as'         => 'business_user_create',
            'uses'       => 'BusinessUserController@business_user_create'
        ]);
        $router->put('user/{business_user_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_edit',
            'uses'       => 'BusinessUserController@business_user_edit'
        ]);
        $router->delete('user/{business_user_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_delete',
            'uses'       => 'BusinessUserController@business_user_delete'
        ]);

        $router->get('user-quota', [
            'middleware' => 'auth',
            'as'         => 'business_user_quota',
            'uses'       => 'BusinessUserController@business_user_quota'
        ]);
        $router->post('resend-verification', [
            'middleware' => 'auth',
            'as'         => 'user_resend_verification',
            'uses'       => 'BusinessUserController@user_resend_verification'
        ]);

        // BUSINESS USER GROUP
        $router->get('user-group', [
            'middleware' => 'auth',
            'as'         => 'business_user_group_list',
            'uses'       => 'BusinessUserController@business_user_group_list'
        ]);
        $router->get('user-group/{business_user_group_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_group_view',
            'uses'       => 'BusinessUserController@business_user_group_view'
        ]);
        $router->post('user-group', [
            'middleware' => 'auth',
            'as'         => 'business_user_group_create',
            'uses'       => 'BusinessUserController@business_user_group_create'
        ]);
        $router->put('user-group/{business_user_group_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_group_edit',
            'uses'       => 'BusinessUserController@business_user_group_edit'
        ]);
        $router->delete('user-group/{business_user_group_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_group_delete',
            'uses'       => 'BusinessUserController@business_user_group_delete'
        ]);
        $router->put('user-unlock/{business_user_id}', [
            'middleware' => 'auth',
            'as'         => 'unlock',
            'uses'       => 'BusinessUserController@unlock'
        ]);

        // STAFF NON USER
        $router->get('business-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_list',
            'uses'       => 'BusinessUserController@business_commission_worker_list'
        ]);
        $router->get('business-commission-worker/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_view',
            'uses'       => 'BusinessUserController@business_commission_worker_view'
        ]);
        $router->post('business-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_create',
            'uses'       => 'BusinessUserController@business_commission_worker_create'
        ]);
        $router->put('business-commission-worker/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_edit',
            'uses'       => 'BusinessUserController@business_commission_worker_edit'
        ]);
        $router->delete('business-commission-worker/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_delete',
            'uses'       => 'BusinessUserController@business_commission_worker_delete'
        ]);
        $router->get('business-commission-worker-by-business/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_by_business_list',
            'uses'       => 'BusinessUserController@business_commission_worker_by_business_list'
        ]);

        //AUTH LOG
        $router->post('auth-log', [
            'middleware' => 'auth',
            'as'         => 'auth_log_list',
            'uses'       => 'BusinessUserController@auth_log_list'
        ]);
        $router->get('auth-log/{business_user_auth_log_id}', [
            'middleware' => 'auth',
            'as'         => 'auth_log_view',
            'uses'       => 'BusinessUserController@auth_log_view'
        ]);

        // BUSINESS USER ROLE
        $router->get('user-role/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_role_list',
            'uses'       => 'BusinessUserController@business_user_role_list'
        ]);

        // BUSINESS USER AUTH ACCESS
        $router->get('auth-access', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_list',
            'uses'       => 'BusinessUserController@business_user_auth_access_list'
        ]);
        $router->get('auth-access/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_view',
            'uses'       => 'BusinessUserController@business_user_auth_access_view'
        ]);
        $router->put('auth-access-up/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_up',
            'uses'       => 'BusinessUserController@business_user_auth_access_up'
        ]);
        $router->put('auth-access-down/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_down',
            'uses'       => 'BusinessUserController@business_user_auth_access_down'
        ]);
        $router->post('auth-access', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_create',
            'uses'       => 'BusinessUserController@business_user_auth_access_create'
        ]);
        $router->put('auth-access/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_edit',
            'uses'       => 'BusinessUserController@business_user_auth_access_edit'
        ]);
        $router->delete('auth-access/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_delete',
            'uses'       => 'BusinessUserController@business_user_auth_access_delete'
        ]);

        // CASHIER BUSINESS USER AUTH ACCESS
        $router->get('cashier-auth-access', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_list',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_list'
        ]);
        $router->get('cashier-auth-access/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_view',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_view'
        ]);
        $router->put('cashier-auth-access-up/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_up',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_up'
        ]);
        $router->put('cashier-auth-access-down/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_down',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_down'
        ]);
        $router->post('cashier-auth-access', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_create',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_create'
        ]);
        $router->put('cashier-auth-access/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_edit',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_edit'
        ]);
        $router->delete('cashier-auth-access/{businessUser_authAccess_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_delete',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_delete'
        ]);

        // FOODCOURT
        $router->get('foodcourt', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_list',
            'uses'       => 'FoodcourtController@foodcourt_list'
        ]);
        $router->get('foodcourt/{business_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_view',
            'uses'       => 'FoodcourtController@foodcourt_view'
        ]);
        $router->put('foodcourt/{business_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_edit',
            'uses'       => 'FoodcourtController@foodcourt_edit'
        ]);

        // FOODCOURT OUTLET
        $router->get('foodcourt-outlet', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_outlet_list',
            'uses'       => 'FoodcourtController@foodcourt_outlet_list'
        ]);
        $router->get('foodcourt-outlet/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_outlet_view',
            'uses'       => 'FoodcourtController@foodcourt_outlet_view'
        ]);
        $router->post('foodcourt-outlet', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_outlet_create',
            'uses'       => 'FoodcourtController@foodcourt_outlet_create'
        ]);
        $router->put('foodcourt-outlet/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_outlet_edit',
            'uses'       => 'FoodcourtController@foodcourt_outlet_edit'
        ]);
        $router->delete('foodcourt-outlet/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_outlet_delete',
            'uses'       => 'FoodcourtController@foodcourt_outlet_delete'
        ]);

        // FOODCOURT SETTINGS
        $router->get('foodcourt-settings', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_settings_list',
            'uses'       => 'FoodcourtController@foodcourt_settings_list'
        ]);
        $router->get('foodcourt-settings/{business_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'get_foodcourt_settings',
            'uses'       => 'FoodcourtController@get_foodcourt_settings'
        ]);
        $router->post('foodcourt-settings/{business_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'set_foodcourt_settings',
            'uses'       => 'FoodcourtController@set_foodcourt_settings'
        ]);

        // INVENTORY
        $router->get('inv-unit', [
            'middleware' => 'auth',
            'as'         => 'inv_unit_list',
            'uses'       => 'InventoryController@inv_unit_list'
        ]);
        $router->get('inv-unit/{inv_unit_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_unit_view',
            'uses'       => 'InventoryController@inv_unit_view'
        ]);
        $router->post('inv-unit', [
            'middleware' => 'auth',
            'as'         => 'inv_unit_create',
            'uses'       => 'InventoryController@inv_unit_create'
        ]);
        $router->put('inv-unit/{inv_unit_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_unit_edit',
            'uses'       => 'InventoryController@inv_unit_edit'
        ]);
        $router->delete('inv-unit/{inv_unit_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_unit_delete',
            'uses'       => 'InventoryController@inv_unit_delete'
        ]);

        // LOYALTY
        $router->get('loyalty', [
            'middleware' => 'auth',
            'as'         => 'loyalty_list',
            'uses'       => 'LoyaltyController@loyalty_list'
        ]);
        $router->get('loyalty/{loyalty_id}', [
            'middleware' => 'auth',
            'as'         => 'loyalty_view',
            'uses'       => 'LoyaltyController@loyalty_view'
        ]);
        $router->post('loyalty', [
            'middleware' => 'auth',
            'as'         => 'loyalty_create',
            'uses'       => 'LoyaltyController@loyalty_create'
        ]);
        $router->put('loyalty/{loyalty_id}', [
            'middleware' => 'auth',
            'as'         => 'loyalty_edit',
            'uses'       => 'LoyaltyController@loyalty_edit'
        ]);
        $router->delete('loyalty/{loyalty_id}', [
            'middleware' => 'auth',
            'as'         => 'loyalty_delete',
            'uses'       => 'LoyaltyController@loyalty_delete'
        ]);

        // REFERRAL REWARD
        $router->get('referral', [
            'middleware' => 'auth',
            'as'         => 'referral_reward_list',
            'uses'       => 'LoyaltyController@referral_reward_list'
        ]);
        $router->get('referral-reward/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_referral_reward',
            'uses'       => 'LoyaltyController@get_referral_reward'
        ]);
        $router->post('referral-reward/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'set_referral_reward',
            'uses'       => 'LoyaltyController@set_referral_reward'
        ]);
        $router->delete('referral-reward/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'delete_referral_reward',
            'uses'       => 'LoyaltyController@delete_referral_reward'
        ]);

        // BIRTHDAY REWARD
        $router->get('birthday', [
            'middleware' => 'auth',
            'as'         => 'birthday_reward_list',
            'uses'       => 'LoyaltyController@birthday_reward_list'
        ]);
        $router->get('birthday-reward/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_birthday_reward',
            'uses'       => 'LoyaltyController@get_birthday_reward'
        ]);
        $router->put('birthday-reward/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'set_birthday_reward',
            'uses'       => 'LoyaltyController@set_birthday_reward'
        ]);
        $router->delete('birthday-reward/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'delete_birthday_reward',
            'uses'       => 'LoyaltyController@delete_birthday_reward'
        ]);

        // REDEMPTION CODE
        $router->get('redemption-code', [
            'middleware' => 'auth',
            'as'         => 'redemption_code_list',
            'uses'       => 'LoyaltyController@redemption_code_list'
        ]);
        $router->get('redemption-code/{business_redemptionCode_id}', [
            'middleware' => 'auth',
            'as'         => 'redemption_code_view',
            'uses'       => 'LoyaltyController@redemption_code_view'
        ]);
        $router->post('redemption-code', [
            'middleware' => 'auth',
            'as'         => 'redemption_code_create',
            'uses'       => 'LoyaltyController@redemption_code_create'
        ]);
        $router->post('redemption-code/{business_redemptionCode_id}', [
            'middleware' => 'auth',
            'as'         => 'redemption_code_edit',
            'uses'       => 'LoyaltyController@redemption_code_edit'
        ]);
        $router->delete('redemption-code/{business_redemptionCode_id}', [
            'middleware' => 'auth',
            'as'         => 'redemption_code_delete',
            'uses'       => 'LoyaltyController@redemption_code_delete'
        ]);

        // MEMBERSHIP
        $router->get('default-membership', [
            'middleware' => 'auth',
            'as'         => 'get_default_membership',
            'uses'       => 'MembershipController@get_default_membership'
        ]);
        $router->get('membership', [
            'middleware' => 'auth',
            'as'         => 'membership_list',
            'uses'       => 'MembershipController@membership_list'
        ]);
        $router->get('membership/{business_membership_id}', [
            'middleware' => 'auth',
            'as'         => 'membership_view',
            'uses'       => 'MembershipController@membership_view'
        ]);
        $router->post('membership', [
            'middleware' => 'auth',
            'as'         => 'membership_create',
            'uses'       => 'MembershipController@membership_create'
        ]);
        $router->post('membership/{business_membership_id}', [
            'middleware' => 'auth',
            'as'         => 'membership_edit',
            'uses'       => 'MembershipController@membership_edit'
        ]);
        $router->delete('membership', [
            'middleware' => 'auth',
            'as'         => 'membership_delete',
            'uses'       => 'MembershipController@membership_delete'
        ]);

        // BUSINESS MEMBERSHIP COUPON
        $router->delete('membership-coupon', [
            'middleware' => 'auth',
            'as'         => 'membership_coupon_delete',
            'uses'       => 'MembershipController@membership_coupon_delete'
        ]);

        // BUSINESS GENERAL
        $router->get('outlet-by-brand/{brand_id}', [
            'middleware' => 'auth',
            'as'         => 'get_outlets_by_brand',
            'uses'       => 'OfficeController@get_outlets_by_brand'
        ]);
        $router->get('business/outlet/{business_id}/{outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'check_outlet_in_business',
            'uses'       => 'OfficeController@check_outlet_in_business'
        ]);
        $router->get('business-user/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_business_users',
            'uses'       => 'OfficeController@get_business_users'
        ]);
        $router->get('cashier-business-user/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_cashier_business_users',
            'uses'       => 'OfficeController@get_cashier_business_users'
        ]);
        $router->get('business-user-group/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_business_user_groups',
            'uses'       => 'OfficeController@get_business_user_groups'
        ]);
        $router->get('business-outlet/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_business_outlets',
            'uses'       => 'OfficeController@get_business_outlets'
        ]);
        $router->get('business-membership', [
            'middleware' => 'auth',
            'as'         => 'get_business_memberships',
            'uses'       => 'OfficeController@get_business_memberships'
        ]);
        $router->get('business-reward-redemption-item', [
            'middleware' => 'auth',
            'as'         => 'get_business_reward_redemption_items',
            'uses'       => 'OfficeController@get_business_reward_redemption_items'
        ]);
        $router->get('business-reward', [
            'middleware' => 'auth',
            'as'         => 'get_business_rewards',
            'uses'       => 'OfficeController@get_business_rewards'
        ]);
        $router->put('business-reward', [
            'middleware' => 'auth',
            'as'         => 'business_reward_edit',
            'uses'       => 'OfficeController@business_reward_edit'
        ]);
        $router->get('subscription-feature', [
            'middleware' => 'auth',
            'as'         => 'get_subscription_features',
            'uses'       => 'OfficeController@get_subscription_features'
        ]);

        // CURRENCY
        $router->get('currency', [
            'middleware' => 'auth',
            'as'         => 'currency_list',
            'uses'       => 'OfficeController@currency_list'
        ]);
        $router->get('currency/{currency_id}', [
            'middleware' => 'auth',
            'as'         => 'currency_view',
            'uses'       => 'OfficeController@currency_view'
        ]);
        $router->post('currency', [
            'middleware' => 'auth',
            'as'         => 'currency_create',
            'uses'       => 'OfficeController@currency_create'
        ]);
        $router->put('currency/{currency_id}', [
            'middleware' => 'auth',
            'as'         => 'currency_edit',
            'uses'       => 'OfficeController@currency_edit'
        ]);
        $router->delete('currency/{currency_id}', [
            'middleware' => 'auth',
            'as'         => 'currency_delete',
            'uses'       => 'OfficeController@currency_delete'
        ]);

        // BUSINESS USER FAQ

        $router->get('business-user-faq', [
            'middleware' => 'auth',
            'as'   => 'business_user_faq_list',
            'uses' => 'OfficeController@business_user_faq_list'
        ]);
        $router->post('business-user-faq', [
            'middleware' => 'auth',
            'as'   => 'business_user_faq_create',
            'uses' => 'OfficeController@business_user_faq_create'
        ]);
        $router->get('business-user-faq/{business_user_faq_id}', [
            'middleware' => 'auth',
            'as'   => 'business_user_faq_view',
            'uses' => 'OfficeController@business_user_faq_view'
        ]);
        $router->post('business-user-faq/{business_user_faq_id}', [
            'middleware' => 'auth',
            'as'   => 'business_user_faq_edit',
            'uses' => 'OfficeController@business_user_faq_edit'
        ]);
        $router->delete('business-user-faq/{business_user_faq_id}', [
            'middleware' => 'auth',
            'as'   => 'business_user_faq_delete',
            'uses' => 'OfficeController@business_user_faq_delete'
        ]);

        // RUNNING TEXT

        $router->get('running-text', [
            'middleware' => 'auth',
            'as'   => 'running_text_list',
            'uses' => 'OfficeController@running_text_list'
        ]);
        $router->post('running-text', [
            'middleware' => 'auth',
            'as'   => 'running_text_create',
            'uses' => 'OfficeController@running_text_create'
        ]);
        $router->get('running-text/{running_text_id}', [
            'middleware' => 'auth',
            'as'   => 'running_text_view',
            'uses' => 'OfficeController@running_text_view'
        ]);
        $router->post('running-text/{running_text_id}', [
            'middleware' => 'auth',
            'as'   => 'running_text_edit',
            'uses' => 'OfficeController@running_text_edit'
        ]);
        $router->delete('running-text/{running_text_id}', [
            'middleware' => 'auth',
            'as'   => 'running_text_delete',
            'uses' => 'OfficeController@running_text_delete'
        ]);

        // ERROR REF

        $router->get('error-ref', [
            'middleware' => 'auth',
            'as'   => 'error_ref_list',
            'uses' => 'OfficeController@error_ref_list'
        ]);
        $router->post('error-ref', [
            'middleware' => 'auth',
            'as'   => 'error_ref_create',
            'uses' => 'OfficeController@error_ref_create'
        ]);
        $router->get('error-ref/{error_ref_id}', [
            'middleware' => 'auth',
            'as'   => 'error_ref_view',
            'uses' => 'OfficeController@error_ref_view'
        ]);
        $router->post('error-ref/{error_ref_id}', [
            'middleware' => 'auth',
            'as'   => 'error_ref_edit',
            'uses' => 'OfficeController@error_ref_edit'
        ]);
        $router->delete('error-ref/{error_ref_id}', [
            'middleware' => 'auth',
            'as'   => 'error_ref_delete',
            'uses' => 'OfficeController@error_ref_delete'
        ]);

        // MASS ACTIVATION
        $router->get('mass-activation', [
            'middleware' => 'auth',
            'as'   => 'mass_activation_list',
            'uses' => 'OfficeController@mass_activation_list'
        ]);
        $router->post('mass-activation', [
            'middleware' => 'auth',
            'as'   => 'mass_activation_create',
            'uses' => 'OfficeController@mass_activation_create'
        ]);
        $router->post('activation', [
            'middleware' => 'auth',
            'as'   => 'activation_create',
            'uses' => 'OfficeController@activation_create'
        ]);
        $router->get('mass-activation/{mass_activation_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_activation_view',
            'uses' => 'OfficeController@mass_activation_view'
        ]);
        $router->post('mass-activation/{mass_activation_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_activation_edit',
            'uses' => 'OfficeController@mass_activation_edit'
        ]);
        $router->delete('mass-activation/{mass_activation_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_activation_delete',
            'uses' => 'OfficeController@mass_activation_delete'
        ]);
        $router->post('mass-activation-script/{mass_activation_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_activation_edit_script',
            'uses' => 'OfficeController@mass_activation_edit_script'
        ]);

        // MASS BLAST
        $router->post('mass-blast', [
            'middleware' => 'auth',
            'as'   => 'mass_blast_create',
            'uses' => 'OfficeController@mass_blast_create'
        ]);

        // MASS MIGRATION
        $router->get('mass-migration', [
            'middleware' => 'auth',
            'as'   => 'mass_migration_list',
            'uses' => 'OfficeController@mass_migration_list'
        ]);
        $router->post('mass-migration', [
            'middleware' => 'auth',
            'as'   => 'mass_migration_create',
            'uses' => 'OfficeController@mass_migration_create'
        ]);
        $router->get('mass-migration/{mass_migration_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_migration_view',
            'uses' => 'OfficeController@mass_migration_view'
        ]);
        $router->post('mass-migration/{mass_migration_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_migration_edit',
            'uses' => 'OfficeController@mass_migration_edit'
        ]);
        $router->delete('mass-migration/{mass_migration_id}', [
            'middleware' => 'auth',
            'as'   => 'mass_migration_delete',
            'uses' => 'OfficeController@mass_migration_delete'
        ]);

        // SMS LOG
        $router->post('sms-log', [
            'middleware' => 'auth',
            'as'   => 'sms_log_list',
            'uses' => 'OfficeController@sms_log_list'
        ]);
        $router->post('sms-resend/{sms_log_id}', [
            'middleware' => 'auth',
            'as'   => 'sms_resend',
            'uses' => 'OfficeController@sms_resend'
        ]);

        // WA LOG
        $router->post('wa-log', [
            'middleware' => 'auth',
            'as'   => 'wa_log_list',
            'uses' => 'OfficeController@wa_log_list'
        ]);
        $router->post('wa-resend/{wa_log_id}', [
            'middleware' => 'auth',
            'as'   => 'wa_resend',
            'uses' => 'OfficeController@wa_resend'
        ]);

        // CHAT REPORT LOG / BUSINESS USER REPORT LOG
        $router->post('business-report-user-log', [
            'middleware' => 'auth',
            'as'   => 'busienss_reportUser_log_list',
            'uses' => 'LogController@busienss_reportUser_log_list'
        ]);
        $router->get('business-report-user-log/{business_userReport_log_id}', [
            'middleware' => 'auth',
            'as'   => 'busienss_reportUser_log_view',
            'uses' => 'LogController@busienss_reportUser_log_view'
        ]);

        // REPORT ASSISTANT
        $router->get('report-assistant', [
            'middleware' => 'auth',
            'as'   => 'report_assistant_list',
            'uses' => 'OfficeController@report_assistant_list'
        ]);
        $router->post('report-assistant', [
            'middleware' => 'auth',
            'as'   => 'report_assistant_create',
            'uses' => 'OfficeController@report_assistant_create'
        ]);
        $router->get('report-assistant/{report_assistant_id}', [
            'middleware' => 'auth',
            'as'   => 'report_assistant_view',
            'uses' => 'OfficeController@report_assistant_view'
        ]);
        $router->post('report-assistant/{report_assistant_id}', [
            'middleware' => 'auth',
            'as'   => 'report_assistant_edit',
            'uses' => 'OfficeController@report_assistant_edit'
        ]);
        $router->delete('report-assistant/{report_assistant_id}', [
            'middleware' => 'auth',
            'as'   => 'report_assistant_delete',
            'uses' => 'OfficeController@report_assistant_delete'
        ]);

        // SETTING
        $router->get('setting', [
            'middleware' => 'auth',
            'as'         => 'get_setting',
            'uses'       => 'OfficeController@get_setting'
        ]);
        $router->post('setting', [
            'middleware' => 'auth',
            'as'         => 'set_setting',
            'uses'       => 'OfficeController@set_setting'
        ]);

        // SYNC
        $router->get('sync', [
            'as'   => 'sync_db',
            'uses' => 'OfficeController@sync_db'
        ]);

        // OTHERS
        $router->get('delete_user', [
            'as'   => 'user_delete',
            'uses' => 'OfficeController@user_delete'
        ]);
        $router->post('notification', [
            'as'   => 'notification_create',
            'uses' => 'OfficeController@notification_create'
        ]);
        $router->get('loyalty-method', [
            'middleware' => 'auth',
            'as'         => 'loyalty_method_list',
            'uses'       => 'OfficeController@loyalty_method_list'
        ]);
        $router->get('loyalty-method/{loyalty_method_id}', [
            'middleware' => 'auth',
            'as'         => 'loyalty_method_view',
            'uses'       => 'OfficeController@loyalty_method_view'
        ]);
        $router->get('reward_type', [
            'middleware' => 'auth',
            'as'         => 'reward_type_list',
            'uses'       => 'OfficeController@reward_type_list'
        ]);
//    $router->get('promo', [
//        'middleware' => 'auth',
//        'as'         => 'business_promo_list',
//        'uses'       => 'OfficeController@business_promo_list'
//    ]);
        $router->get('member', [
            'middleware' => 'auth',
            'as'         => 'membership_user_list',
            'uses'       => 'OfficeController@membership_user_list'
        ]);
        $router->get('subscription-plan', [
            'middleware' => 'auth',
            'as'         => 'subscription_plan',
            'uses'       => 'OfficeController@subscription_plan'
        ]);
        $router->get('subscription', [
            'middleware' => 'auth',
            'as'         => 'subscription',
            'uses'       => 'OfficeController@subscription'
        ]);
        $router->get('mass-activation-script/{mass_activation_id}', [
            'middleware' => 'auth',
            'as'         => 'mass_activation_script',
            'uses'       => 'OfficeController@mass_activation_script'
        ]);

        // USER
        $router->get('user-business', [
            'middleware' => 'auth',
            'as'         => 'get_user_businesses',
            'uses'       => 'UserController@get_user_businesses'
        ]);
        $router->put('change-user-phone', [
            'middleware' => 'auth',
            'as'         => 'change_user_phone',
            'uses'       => 'UserController@change_user_phone'
        ]);
        $router->post('member/info', [
            'middleware' => 'auth',
            'as'         => 'member_info',
            'uses'       => 'UserController@member_info'
        ]);

        // POS ITEM MASS UPLOAD
        $router->get('pos-item-mass-upload', [
            'middleware' => 'auth',
            'as'         => 'mass_item_upload_list',
            'uses'       => 'PosController@mass_item_upload_list'
        ]);
        $router->get('pos-item-mass-upload/{mass_item_upload_id}', [
            'middleware' => 'auth',
            'as'         => 'mass_item_upload_view',
            'uses'       => 'PosController@mass_item_upload_view'
        ]);
        $router->post('pos-item-mass-upload', [
            'middleware' => 'auth',
            'as'         => 'mass_item_upload_create',
            'uses'       => 'PosController@mass_item_upload_create'
        ]);
        $router->post('rerun-pos-item-mass-upload/{mass_item_upload_id}', [
            'middleware' => 'auth',
            'as'         => 'rerun_mass_item_upload',
            'uses'       => 'PosController@rerun_mass_item_upload'
        ]);
        $router->delete('pos-item-mass-upload/{mass_item_upload_id}', [
            'middleware' => 'auth',
            'as'         => 'mass_item_upload_delete',
            'uses'       => 'PosController@mass_item_upload_delete'
        ]);

        // POS ITEM VARIANT MASS UPLOAD
        $router->post('pos-item-variant-mass-upload', [
            'middleware' => 'auth',
            'as'         => 'mass_item_variant_upload_create',
            'uses'       => 'PosController@mass_item_variant_upload_create'
        ]);

        // PROMO
        $router->put('promo-notification/{promo_id}', [
            'middleware' => 'auth',
            'as'         => 'create_user_notification',
            'uses'       => 'PromoController@create_user_notification'
        ]);

        // BUSINESS EMAIL REPORT
        $router->get('email-report', [
            'middleware' => 'auth',
            'as'         => 'business_email_report_list',
            'uses'       => 'ReportController@business_email_report_list'
        ]);
        $router->get('email-report/{business_email_report_id}', [
            'middleware' => 'auth',
            'as'         => 'business_email_report_view',
            'uses'       => 'ReportController@business_email_report_view'
        ]);
        $router->post('email-report', [
            'middleware' => 'auth',
            'as'         => 'business_email_report_create',
            'uses'       => 'ReportController@business_email_report_create'
        ]);
        $router->put('email-report/{business_email_report_id}', [
            'middleware' => 'auth',
            'as'         => 'business_email_report_edit',
            'uses'       => 'ReportController@business_email_report_edit'
        ]);
        $router->delete('email-report/{business_email_report_id}', [
            'middleware' => 'auth',
            'as'         => 'business_email_report_delete',
            'uses'       => 'ReportController@business_email_report_delete'
        ]);
        $router->post('email-report-confirmation', [
            'as'         => 'business_email_report_confirmation',
            'uses'       => 'ReportController@business_email_report_confirmation'
        ]);

        // BUSINESS USER REPORT
        $router->get('chat-report', [
            'middleware' => 'auth',
            'as'         => 'business_chat_report_list',
            'uses'       => 'ReportController@business_chat_report_list'
        ]);
        $router->get('chat-report/{business_reportUser_filter_id}', [
            'middleware' => 'auth',
            'as'         => 'business_chat_report_view',
            'uses'       => 'ReportController@business_chat_report_view'
        ]);
        $router->post('chat-report', [
            'middleware' => 'auth',
            'as'         => 'business_chat_report_create',
            'uses'       => 'ReportController@business_chat_report_create'
        ]);
        $router->put('chat-report/{business_reportUser_filter_id}', [
            'middleware' => 'auth',
            'as'         => 'business_chat_report_edit',
            'uses'       => 'ReportController@business_chat_report_edit'
        ]);
        $router->delete('chat-report/{business_reportUser_filter_id}', [
            'middleware' => 'auth',
            'as'         => 'business_chat_report_delete',
            'uses'       => 'ReportController@business_chat_report_delete'
        ]);

        // LOYALTY REPORT
        $router->post('report/magic-filter', [
            'middleware' => 'auth',
            'as'         => 'retrieve_magic_filter_list',
            'uses'       => 'LoyaltyReportController@retrieve_magic_filter_list'
        ]);
        $router->post('report/pos/transaction', [
            'middleware' => 'auth',
            'as'         => 'retrieve_transaction_list',
            'uses'       => 'LoyaltyReportController@retrieve_transaction_list'
        ]);
        $router->get('report/pos/loyalty/transaction', [
            'middleware' => 'auth',
            'as'         => 'retrieve_loyalty_transaction_list',
            'uses'       => 'LoyaltyReportController@retrieve_loyalty_transaction_list'
        ]);
        $router->get('report/loyalty/detail/{loyalty_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_loyalty_transaction',
            'uses' => 'LoyaltyReportController@retrieve_loyalty_transaction'
        ]);
        $router->get('report/membership/detail/{business_membership_trx_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_membership_transaction',
            'uses' => 'LoyaltyReportController@retrieve_membership_transaction'
        ]);
        $router->get('report/pos/reward/transaction', [
            'middleware' => 'auth',
            'as'         => 'retrieve_reward_transaction_list',
            'uses'       => 'LoyaltyReportController@retrieve_reward_transaction_list'
        ]);
        $router->get('report/reward/detail/{reward_trx_head_id}', [
            'middleware' => 'auth',
            'as'         => 'retrieve_reward_transaction',
            'uses'       => 'LoyaltyReportController@retrieve_reward_transaction'
        ]);
        $router->get('report/reward/void-detail/{reward_trx_void_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_reward_transaction_void',
            'uses' => 'LoyaltyReportController@retrieve_reward_transaction_void'
        ]);
        $router->post('report/customer', [
            'middleware' => 'auth',
            'as'         => 'retrieve_customer_list',
            'uses'       => 'LoyaltyReportController@retrieve_customer_list'
        ]);
        $router->post('report/member', [
            'middleware' => 'auth',
            'as'         => 'retrieve_member_list',
            'uses'       => 'LoyaltyReportController@retrieve_member_list'
        ]);
        $router->post('report/pos/transaction/rating', [
            'middleware' => 'auth',
            'as'         => 'retrieve_transaction_rating',
            'uses'       => 'LoyaltyReportController@retrieve_transaction_rating'
        ]);
        $router->post('report/pos/migration/transaction-history', [
            'middleware' => 'auth',
            'as'         => 'retrieve_migration_history',
            'uses'       => 'LoyaltyReportController@retrieve_migration_history'
        ]);
        $router->post('report/birthday-history', [
            'middleware' => 'auth',
            'as'         => 'retrieve_birthday_history',
            'uses'       => 'LoyaltyReportController@retrieve_birthday_history'
        ]);
        $router->post('report/referrer-history', [
            'middleware' => 'auth',
            'as'         => 'retrieve_referrer_history',
            'uses'       => 'LoyaltyReportController@retrieve_referrer_history'
        ]);
        $router->post('report/referred-history', [
            'middleware' => 'auth',
            'as'         => 'retrieve_referred_history',
            'uses'       => 'LoyaltyReportController@retrieve_referred_history'
        ]);

        // TRX DETAIL REPORT
        $router->get('report/pos/detail/{pos_sales_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_transaction',
            'uses' => 'PosReportController@retrieve_pos_transaction'
        ]);

        // POS REPORT
        $router->post('report/pos-transaction', [
            'middleware' => 'auth',
            'as'         => 'retrieve_pos_transaction_list',
            'uses'       => 'PosReportController@retrieve_pos_transaction_list'
        ]);

        // REDEEM BLOCKER
        $router->get('redeem-blocker', [
            'middleware' => 'auth',
            'as'         => 'redeem_blocker_list',
            'uses'       => 'RewardController@redeem_blocker_list'
        ]);
        $router->get('redeem-blocker/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_redeem_blocker',
            'uses'       => 'RewardController@get_redeem_blocker'
        ]);
        $router->post('redeem-blocker/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'set_redeem_blocker',
            'uses'       => 'RewardController@set_redeem_blocker'
        ]);
        $router->delete('redeem-blocker/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'delete_redeem_blocker',
            'uses'       => 'RewardController@delete_redeem_blocker'
        ]);
        $router->get('redeem-blocker-statistic/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'retrieve_redeem_blocker_statistic_list',
            'uses'       => 'RewardController@retrieve_redeem_blocker_statistic_list'
        ]);
        $router->post('blocked-member/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'retrieve_blocked_member_list',
            'uses'       => 'RewardController@retrieve_blocked_member_list'
        ]);
        $router->put('redeem-block-status/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'redeem_block_status_edit',
            'uses'       => 'RewardController@redeem_block_status_edit'
        ]);
        $router->put('unblock-permanent/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'unblock_permanent',
            'uses'       => 'RewardController@unblock_permanent'
        ]);
        $router->put('unblock-temporary/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'unblock_temporary',
            'uses'       => 'RewardController@unblock_temporary'
        ]);

        // REWARD
        $router->get('reward/{reward_id}', [
            'middleware' => 'auth',
            'as'         => 'reward_view',
            'uses'       => 'RewardController@reward_view'
        ]);
        $router->get('reward-type', [
            'middleware' => 'auth',
            'as'         => 'reward_type_list',
            'uses'       => 'RewardController@reward_type_list'
        ]);

        // REWARD REDEMPTION ITEM
        $router->get('reward-redemption-item', [
            'middleware' => 'auth',
            'as'         => 'reward_redemption_item_list',
            'uses'       => 'RewardController@reward_redemption_item_list'
        ]);
        $router->get('reward-redemption-item/{reward_redemption_item_id}', [
            'middleware' => 'auth',
            'as'         => 'reward_redemption_item_view',
            'uses'       => 'RewardController@reward_redemption_item_view'
        ]);
        $router->post('reward-redemption-item', [
            'middleware' => 'auth',
            'as'         => 'reward_redemption_item_create',
            'uses'       => 'RewardController@reward_redemption_item_create'
        ]);
        $router->post('reward-redemption-item/{reward_redemption_item_id}', [
            'middleware' => 'auth',
            'as'         => 'reward_redemption_item_edit',
            'uses'       => 'RewardController@reward_redemption_item_edit'
        ]);
        $router->delete('reward-redemption-item/{reward_redemption_item_id}', [
            'middleware' => 'auth',
            'as'         => 'reward_redemption_item_delete',
            'uses'       => 'RewardController@reward_redemption_item_delete'
        ]);

        // WALLET
        $router->get('wallet/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'get_business_wallets',
            'uses'       => 'WalletController@get_business_wallets'
        ]);
        $router->put('wallet/{business_id}', [
            'middleware' => 'auth',
            'as'         => 'wallet_edit',
            'uses'       => 'WalletController@wallet_edit'
        ]);
    });
});

$router->group(['prefix' => 'office'], function () use ($router) {
    //GENERAL

    $router->get('brand', [
        'as'   => 'get_brands',
        'uses' => 'GeneralController@get_brands'
    ]);
    $router->get('subscription', [
        'as'   => 'get_subscriptions',
        'uses' => 'GeneralController@get_subscriptions'
    ]);
    $router->get('client', [
        'as'   => 'get_clients',
        'uses' => 'GeneralController@get_clients'
    ]);
    $router->get('city', [
        'as'   => 'get_cities',
        'uses' => 'GeneralController@get_cities'
    ]);
    $router->get('category', [
        'as'   => 'get_categories',
        'uses' => 'GeneralController@get_categories'
    ]);
    $router->post('image', [
        'middleware' => 'auth',
        'as'   => 'upload_image',
        'uses' => 'GeneralController@upload_image'
    ]);
});
