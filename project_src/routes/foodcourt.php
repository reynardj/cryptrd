<?php
$router->group(['namespace' => 'Foodcourt'], function () use ($router) {
    $router->group(['prefix' => 'foodcourt'], function () use ($router) {
        // BUSINESS
        $router->get('business', [
            'middleware' => 'auth',
            'as'         => 'get_business_profile',
            'uses'       => 'BusinessController@get_business_profile'
        ]);
        $router->post('business', [
            'middleware' => 'auth',
            'as'         => 'set_business_profile',
            'uses'       => 'BusinessController@set_business_profile'
        ]);
        $router->get('business/brand/qr-code', [
            'middleware' => 'auth',
            'as'         => 'business_qr_code',
            'uses'       => 'BusinessController@business_qr_code'
        ]);
        $router->get('business/brand/qr-code/{brand_id}', [
            'middleware' => 'auth',
            'as'         => 'brand_qr_code',
            'uses'       => 'BusinessController@brand_qr_code'
        ]);
        $router->get('business/outlet/qr-code', [
            'middleware' => 'auth',
            'as'         => 'outlet_qr_code',
            'uses'       => 'BusinessController@outlet_qr_code'
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

        // FOODCOURT SETTINGS
        $router->get('settings', [
            'middleware' => 'auth',
            'as'         => 'foodcourt_settings_list',
            'uses'       => 'FoodcourtController@foodcourt_settings_list'
        ]);
        $router->get('settings/{business_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'get_foodcourt_settings',
            'uses'       => 'FoodcourtController@get_foodcourt_settings'
        ]);
        $router->post('settings/{business_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'set_foodcourt_settings',
            'uses'       => 'FoodcourtController@set_foodcourt_settings'
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
        $router->post('membership/{business_membership_id}', [
            'middleware' => 'auth',
            'as'         => 'membership_edit',
            'uses'       => 'MembershipController@membership_edit'
        ]);

        // BUSINESS OUTLET
        $router->get('business/outlet', [
            'middleware' => 'auth',
            'as'         => 'get_business_outlets',
            'uses'       => 'OutletController@get_business_outlets'
        ]);
        $router->get('business/requested-outlet', [
            'middleware' => 'auth',
            'as'         => 'get_business_requested_outlets',
            'uses'       => 'OutletController@get_business_requested_outlets'
        ]);
        $router->get('business/requested-outlet/outlet-service', [
            'middleware' => 'auth',
            'as'         => 'get_requested_outlet_services',
            'uses'       => 'OutletController@get_requested_outlet_services'
        ]);
        $router->put('business/requested-outlet/outlet-service', [
            'middleware' => 'auth',
            'as'         => 'edit_requested_outlet_service',
            'uses'       => 'OutletController@edit_requested_outlet_service'
        ]);
        $router->get('business/requested-outlet/outlet-socialmedia', [
            'middleware' => 'auth',
            'as'         => 'get_requested_outlet_socialmedias',
            'uses'       => 'OutletController@get_requested_outlet_socialmedias'
        ]);
        $router->put('business/requested-outlet/outlet-socialmedia', [
            'middleware' => 'auth',
            'as'         => 'edit_requested_outlet_socialmedia',
            'uses'       => 'OutletController@edit_requested_outlet_socialmedia'
        ]);
        $router->get('business/requested-outlet/outlet-hour', [
            'middleware' => 'auth',
            'as'         => 'get_requested_outlet_hours',
            'uses'       => 'OutletController@get_requested_outlet_hours'
        ]);
        $router->get('business/requested-outlet/outlet-phone', [
            'middleware' => 'auth',
            'as'         => 'get_requested_outlet_phones',
            'uses'       => 'OutletController@get_requested_outlet_phones'
        ]);
        $router->put('business/requested-outlet/outlet-phone', [
            'middleware' => 'auth',
            'as'         => 'edit_requested_outlet_phone',
            'uses'       => 'OutletController@edit_requested_outlet_phone'
        ]);
        $router->get('business/requested-outlet/outlet-email', [
            'middleware' => 'auth',
            'as'         => 'get_requested_outlet_emails',
            'uses'       => 'OutletController@get_requested_outlet_emails'
        ]);
        $router->put('business/requested-outlet/outlet-email', [
            'middleware' => 'auth',
            'as'         => 'edit_requested_outlet_email',
            'uses'       => 'OutletController@edit_requested_outlet_email'
        ]);
        $router->post('business/request-outlet', [
            'middleware' => 'auth',
            'as'         => 'request_outlet',
            'uses'       => 'OutletController@request_outlet'
        ]);
        $router->put('business/requested-outlet', [
            'middleware' => 'auth',
            'as'         => 'edit_requested_outlet',
            'uses'       => 'OutletController@edit_requested_outlet'
        ]);
        $router->delete('business/requested-outlet', [
            'middleware' => 'auth',
            'as'         => 'delete_requested_outlet',
            'uses'       => 'OutletController@delete_requested_outlet'
        ]);

        // OUTLET
        $router->get('outlet', [
            'middleware' => 'auth',
            'as'         => 'view_outlet',
            'uses'       => 'OutletController@view_outlet'
        ]);
        $router->get('outlet/outlet-service', [
            'middleware' => 'auth',
            'as'         => 'get_outlet_services',
            'uses'       => 'OutletController@get_outlet_services'
        ]);
        $router->get('outlet/outlet-socialmedia', [
            'middleware' => 'auth',
            'as'         => 'get_outlet_socialmedias',
            'uses'       => 'OutletController@get_outlet_socialmedias'
        ]);
        $router->get('outlet/outlet-hour', [
            'middleware' => 'auth',
            'as'         => 'get_outlet_hours',
            'uses'       => 'OutletController@get_outlet_hours'
        ]);
        $router->get('outlet/outlet-phone', [
            'middleware' => 'auth',
            'as'         => 'get_outlet_phones',
            'uses'       => 'OutletController@get_outlet_phones'
        ]);
        $router->get('outlet/outlet-email', [
            'middleware' => 'auth',
            'as'         => 'get_outlet_emails',
            'uses'       => 'OutletController@get_outlet_emails'
        ]);

        // PROMO
        $router->get('promo/published', [
            'middleware' => 'auth',
            'as'         => 'promo_published_list',
            'uses'       => 'PromoController@promo_published_list'
        ]);
        $router->get('promo/published/{promo_id}', [
            'middleware' => 'auth',
            'as'         => 'promo_published_view',
            'uses'       => 'PromoController@promo_published_view'
        ]);

        $router->get('promo/requested', [
            'middleware' => 'auth',
            'as'         => 'promo_request_list',
            'uses'       => 'PromoController@promo_request_list'
        ]);
        $router->get('promo/requested/{promo_request_id}', [
            'middleware' => 'auth',
            'as'         => 'promo_request_view',
            'uses'       => 'PromoController@promo_request_view'
        ]);
        $router->post('promo/requested', [
            'middleware' => 'auth',
            'as'         => 'promo_request_create',
            'uses'       => 'PromoController@promo_request_create'
        ]);
        $router->post('promo/requested/{promo_request_id}', [
            'middleware' => 'auth',
            'as'         => 'promo_request_edit',
            'uses'       => 'PromoController@promo_request_edit'
        ]);
        $router->delete('promo/requested/{promo_request_id}', [
            'middleware' => 'auth',
            'as'         => 'promo_request_delete',
            'uses'       => 'PromoController@promo_request_delete'
        ]);

        // REWARD
        $router->get('reward-type', [
            'middleware' => 'auth',
            'as'         => 'reward_type_list',
            'uses'       => 'RewardController@reward_type_list'
        ]);
        $router->get('reward', [
            'middleware' => 'auth',
            'as'         => 'reward_list',
            'uses'       => 'RewardController@reward_list'
        ]);
        $router->get('reward/{reward_id}', [
            'middleware' => 'auth',
            'as'         => 'reward_view',
            'uses'       => 'RewardController@reward_view'
        ]);
        $router->put('reward', [
            'middleware' => 'auth',
            'as'         => 'reward_edit',
            'uses'       => 'RewardController@reward_edit'
        ]);

        // TENANT
        $router->get('tenant', [
            'middleware' => 'auth',
            'as'         => 'tenant_list',
            'uses'       => 'TenantController@tenant_list'
        ]);

        // TENANT CATEGORY
        $router->get('tenant-category', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_list',
            'uses'       => 'TenantController@tenant_category_list'
        ]);
        $router->get('tenant-category/{foodcourt_tenant_category_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_view',
            'uses'       => 'TenantController@tenant_category_view'
        ]);
        $router->post('tenant-category', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_create',
            'uses'       => 'TenantController@tenant_category_create'
        ]);
        $router->put('tenant-category/{foodcourt_tenant_category_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_edit',
            'uses'       => 'TenantController@tenant_category_edit'
        ]);
        $router->delete('tenant-category/{foodcourt_tenant_category_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_delete',
            'uses'       => 'TenantController@tenant_category_delete'
        ]);

        // TENANT CATEGORY DETAIL
        $router->get('tenant-category-detail', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_detail_list',
            'uses'       => 'TenantController@tenant_category_detail_list'
        ]);
        $router->get('tenant-category-detail/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_detail_view',
            'uses'       => 'TenantController@tenant_category_detail_view'
        ]);
        $router->post('tenant-category-detail', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_detail_create',
            'uses'       => 'TenantController@tenant_category_detail_create'
        ]);
        $router->put('tenant-category-detail/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_detail_edit',
            'uses'       => 'TenantController@tenant_category_detail_edit'
        ]);
        $router->delete('tenant-category-detail/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_category_detail_delete',
            'uses'       => 'TenantController@tenant_category_detail_delete'
        ]);

        // TENANT MENU
        $router->get('tenant-menu', [
            'middleware' => 'auth',
            'as'         => 'tenant_menu_list',
            'uses'       => 'TenantController@tenant_menu_list'
        ]);
        $router->get('tenant-menu-detail/{foodcourt_outlet_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_menu_detail_list',
            'uses'       => 'TenantController@tenant_menu_detail_list'
        ]);
        $router->put('tenant-menu/approve/{foodcourt_outlet_menu_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_menu_approve',
            'uses'       => 'TenantController@tenant_menu_approve'
        ]);
        $router->put('tenant-menu/reject/{foodcourt_outlet_menu_id}', [
            'middleware' => 'auth',
            'as'         => 'tenant_menu_reject',
            'uses'       => 'TenantController@tenant_menu_reject'
        ]);
    });
});

$router->group(['prefix' => 'foodcourt'], function () use ($router) {
// AUTH
    $router->post('auth/sign-in', [
        'uses' => 'AuthController@business_user_signin'
    ]);
    $router->post('auth/forgot-password', [
        'uses' => 'AuthController@forgot_password'
    ]);
    $router->post('auth/new-password', [
        'uses' => 'AuthController@new_password'
    ]);

    $router->post('auth/code-verification', [
        'uses' => 'AuthController@code_verification'
    ]);
    $router->post('auth/user-verification', [
        'uses' => 'AuthController@user_verification'
    ]);

    // OTHERS
    $router->get('loyalty-method', [
        'middleware' => 'auth',
        'as'         => 'loyalty_method_list',
        'uses'       => 'MerchantController@loyalty_method_list'
    ]);
    $router->get('loyalty-method/{loyalty_method_id}', [
        'middleware' => 'auth',
        'as'         => 'loyalty_method_view',
        'uses'       => 'MerchantController@loyalty_method_view'
    ]);
    $router->get('subscription-plan', [
        'middleware' => 'auth',
        'as'         => 'subscription_plan',
        'uses'       => 'MerchantController@subscription_plan'
    ]);
    $router->get('notification', [
        'middleware' => 'auth',
        'as'         => 'notification_list',
        'uses'       => 'MerchantController@notification_list'
    ]);
    $router->get('running-text', [
        'middleware' => 'auth',
        'as'         => 'running_text_list',
        'uses'       => 'MerchantController@running_text_list'
    ]);
});