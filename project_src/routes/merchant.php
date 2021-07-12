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
// MERCHANT
// *******

$router->group(['namespace' => 'Merchant'], function () use ($router) {
    $router->group(['prefix' => 'merchant'], function () use ($router) {
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
        $router->post('jurnal/authorize', [
            'middleware' => 'auth',
            'as'         => 'authorize',
            'uses'       => 'JurnalController@authorize'
        ]);
        $router->get('business-brands', [
            'middleware' => 'auth',
            'as'         => 'get_business_brands',
            'uses'       => 'BusinessController@get_business_brands'
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

        // STAFF NON USER
        $router->get('business-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_list',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_list'
        ]);
        $router->get('business-commission-worker/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_view',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_view'
        ]);
        $router->put('business-commission-worker-up/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_up',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_up'
        ]);
        $router->put('business-commission-worker-down/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_down',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_down'
        ]);
        $router->post('business-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_create',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_create'
        ]);
        $router->put('business-commission-worker/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_edit',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_edit'
        ]);
        $router->delete('business-commission-worker/{business_commission_worker_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_delete',
            'uses'       => 'BusinessCommissionWorkerController@business_commission_worker_delete'
        ]);
        $router->post('pos-item-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'pos_item_commission_worker_list',
            'uses'       => 'BusinessCommissionWorkerController@pos_item_commission_worker_list'
        ]);
        $router->put('pos-item-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'pos_item_commission_worker_edit',
            'uses'       => 'BusinessCommissionWorkerController@pos_item_commission_worker_edit'
        ]);
        $router->put('user-unlock/{business_user_id}', [
            'middleware' => 'auth',
            'as'         => 'unlock',
            'uses'       => 'BusinessUserController@unlock'
        ]);

        // COMMISSION RECALCULATION
        $router->post('pos-sales-trx-commission-recalculation-log-list', [
            'middleware' => 'auth',
            'as'         => 'pos_sales_trx_commission_recalculation_log_list',
            'uses'       => 'BusinessCommissionWorkerController@pos_sales_trx_commission_recalculation_log_list'
        ]);
        $router->post('pos-sales-trx-commission-recalculation-log', [
            'middleware' => 'auth',
            'as'         => 'recalculate_worker_trx_commission',
            'uses'       => 'BusinessCommissionWorkerController@recalculate_worker_trx_commission'
        ]);

        // BUSINESS COMMISSION WORKER GROUP
        $router->get('business-commission-worker-group', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_group_list',
            'uses'       => 'BusinessUserController@business_commission_worker_group_list'
        ]);
        $router->get('business-commission-worker-group/{business_commission_worker_group_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_group_view',
            'uses'       => 'BusinessUserController@business_commission_worker_group_view'
        ]);
        $router->post('business-commission-worker-group', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_group_create',
            'uses'       => 'BusinessUserController@business_commission_worker_group_create'
        ]);
        $router->put('business-commission-worker-group/{business_commission_worker_group_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_group_edit',
            'uses'       => 'BusinessUserController@business_commission_worker_group_edit'
        ]);
        $router->delete('business-commission-worker-group/{business_commission_worker_group_id}', [
            'middleware' => 'auth',
            'as'         => 'business_commission_worker_group_delete',
            'uses'       => 'BusinessUserController@business_commission_worker_group_delete'
        ]);

        // COMMISSION PROFILE
        $router->get('commission-worker-profile/{commission_worker_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_view',
            'uses'       => 'BusinessUserController@commission_worker_profile_view'
        ]);
        $router->get('commission-worker-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_list',
            'uses'       => 'BusinessUserController@commission_worker_profile_list'
        ]);
        $router->post('commission-worker-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_create',
            'uses'       => 'BusinessUserController@commission_worker_profile_create'
        ]);
        $router->put('commission-worker-profile/{commission_worker_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_edit',
            'uses'       => 'BusinessUserController@commission_worker_profile_edit'
        ]);
        $router->delete('commission-worker-profile/{commission_worker_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_delete',
            'uses'       => 'BusinessUserController@commission_worker_profile_delete'
        ]);
        $router->put('commission-worker-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_detail_edit',
            'uses'       => 'BusinessUserController@commission_worker_profile_detail_edit'
        ]);

        // COMMISSION OMZET PROFILE
        $router->get('commission-omzet-profile/{commission_omzet_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_profile_view',
            'uses'       => 'BusinessUserController@commission_omzet_profile_view'
        ]);
        $router->get('commission-omzet-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_profile_list',
            'uses'       => 'BusinessUserController@commission_omzet_profile_list'
        ]);
        $router->post('commission-omzet-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_profile_create',
            'uses'       => 'BusinessUserController@commission_omzet_profile_create'
        ]);
        $router->put('commission-omzet-profile/{commission_omzet_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_profile_edit',
            'uses'       => 'BusinessUserController@commission_omzet_profile_edit'
        ]);
        $router->delete('commission-omzet-profile/{commission_omzet_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_profile_delete',
            'uses'       => 'BusinessUserController@commission_omzet_profile_delete'
        ]);
        $router->put('commission-omzet-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_profile_detail_edit',
            'uses'       => 'BusinessUserController@commission_omzet_profile_detail_edit'
        ]);

        // COMMISSION OMZET RULE
        $router->get('commission-omzet-rule/{commission_omzet_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_rule_view',
            'uses'       => 'BusinessUserController@commission_omzet_rule_view'
        ]);
        $router->get('commission-omzet-rule', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_rule_list',
            'uses'       => 'BusinessUserController@commission_omzet_rule_list'
        ]);
        $router->post('commission-omzet-rule', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_rule_create',
            'uses'       => 'BusinessUserController@commission_omzet_rule_create'
        ]);
        $router->put('commission-omzet-rule/{commission_omzet_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_rule_edit',
            'uses'       => 'BusinessUserController@commission_omzet_rule_edit'
        ]);
        $router->delete('commission-omzet-rule/{commission_omzet_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_rule_delete',
            'uses'       => 'BusinessUserController@commission_omzet_rule_delete'
        ]);
        $router->put('commission-omzet-rule-detail', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_rule_detail_edit',
            'uses'       => 'BusinessUserController@commission_omzet_rule_detail_edit'
        ]);

        // COMMISSION SELLER OMZET PROFILE
        $router->get('commission-seller-omzet-profile/{commission_omzet_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_profile_view',
            'uses'       => 'BusinessUserController@commission_seller_omzet_profile_view'
        ]);
        $router->get('commission-seller-omzet-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_profile_list',
            'uses'       => 'BusinessUserController@commission_seller_omzet_profile_list'
        ]);
        $router->post('commission-seller-omzet-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_profile_create',
            'uses'       => 'BusinessUserController@commission_seller_omzet_profile_create'
        ]);
        $router->put('commission-seller-omzet-profile/{commission_omzet_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_profile_edit',
            'uses'       => 'BusinessUserController@commission_seller_omzet_profile_edit'
        ]);
        $router->delete('commission-seller-omzet-profile/{commission_omzet_profile_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_profile_delete',
            'uses'       => 'BusinessUserController@commission_seller_omzet_profile_delete'
        ]);
        $router->put('commission-seller-omzet-profile', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_profile_detail_edit',
            'uses'       => 'BusinessUserController@commission_seller_omzet_profile_detail_edit'
        ]);

        // COMMISSION SELLER OMZET RULE
        $router->get('commission-seller-omzet-rule/{commission_omzet_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_rule_view',
            'uses'       => 'BusinessUserController@commission_seller_omzet_rule_view'
        ]);
        $router->get('commission-seller-omzet-rule', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_rule_list',
            'uses'       => 'BusinessUserController@commission_seller_omzet_rule_list'
        ]);
        $router->post('commission-seller-omzet-rule', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_rule_create',
            'uses'       => 'BusinessUserController@commission_seller_omzet_rule_create'
        ]);
        $router->put('commission-seller-omzet-rule/{commission_omzet_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_rule_edit',
            'uses'       => 'BusinessUserController@commission_seller_omzet_rule_edit'
        ]);
        $router->delete('commission-seller-omzet-rule/{commission_omzet_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_rule_delete',
            'uses'       => 'BusinessUserController@commission_seller_omzet_rule_delete'
        ]);
        $router->put('commission-seller-omzet-rule-detail', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_rule_detail_edit',
            'uses'       => 'BusinessUserController@commission_seller_omzet_rule_detail_edit'
        ]);

        // BUSINESS USER ROLE
        $router->get('user-role', [
            'middleware' => 'auth',
            'as'         => 'business_user_role_list',
            'uses'       => 'BusinessUserController@business_user_role_list'
        ]);
        $router->get('user-role/{business_user_role_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_role_view',
            'uses'       => 'BusinessUserController@business_user_role_view'
        ]);
        $router->post('user-role', [
            'middleware' => 'auth',
            'as'         => 'business_user_role_create',
            'uses'       => 'BusinessUserController@business_user_role_create'
        ]);
        $router->put('user-role/{business_user_role_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_role_edit',
            'uses'       => 'BusinessUserController@business_user_role_edit'
        ]);
        $router->delete('user-role/{business_user_role_id}', [
            'middleware' => 'auth',
            'as'         => 'business_user_role_delete',
            'uses'       => 'BusinessUserController@business_user_role_delete'
        ]);

        // CASHIER BUSINESS USER ROLE
        $router->get('cashier-user-role', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_role_list',
            'uses'       => 'BusinessUserController@cashier_business_user_role_list'
        ]);
        $router->get('cashier-user-role/{business_user_role_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_role_view',
            'uses'       => 'BusinessUserController@cashier_business_user_role_view'
        ]);
        $router->post('cashier-user-role', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_role_create',
            'uses'       => 'BusinessUserController@cashier_business_user_role_create'
        ]);
        $router->put('cashier-user-role/{business_user_role_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_role_edit',
            'uses'       => 'BusinessUserController@cashier_business_user_role_edit'
        ]);
        $router->delete('cashier-user-role/{business_user_role_id}', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_role_delete',
            'uses'       => 'BusinessUserController@cashier_business_user_role_delete'
        ]);

        // BUSINESS USER DATATABLE CONFIG
        $router->get('business-user/datatable-config', [
            'middleware' => 'auth',
            'as'         => 'business_user_datatable_config_view',
            'uses'       => 'BusinessUserDatatableConfigController@business_user_datatable_config_view'
        ]);
        $router->post('business-user/datatable-config', [
            'middleware' => 'auth',
            'as'         => 'business_user_datatable_config_create',
            'uses'       => 'BusinessUserDatatableConfigController@business_user_datatable_config_create'
        ]);

        // COUPON
        $router->get('coupon', [
            'middleware' => 'auth',
            'as'         => 'coupon_list',
            'uses'       => 'CouponController@coupon_list'
        ]);
        $router->get('coupon/{coupon_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_view',
            'uses'       => 'CouponController@coupon_view'
        ]);
        $router->post('coupon', [
            'middleware' => 'auth',
            'as'         => 'coupon_create',
            'uses'       => 'CouponController@coupon_create'
        ]);
        $router->post('coupon/{coupon_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_edit',
            'uses'       => 'CouponController@coupon_edit'
        ]);
        $router->delete('coupon/{coupon_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_delete',
            'uses'       => 'CouponController@coupon_delete'
        ]);
        $router->get('free-coupon', [
            'middleware' => 'auth',
            'as'         => 'get_free_coupons',
            'uses'       => 'CouponController@get_free_coupons'
        ]);
        $router->get('coupon-sent', [
            'middleware' => 'auth',
            'as'         => 'sent_coupon_list',
            'uses'       => 'CouponController@sent_coupon_list'
        ]);
        $router->get('coupon-sent/{coupon_trx_head_id}', [
            'middleware' => 'auth',
            'as'         => 'sent_coupon_view',
            'uses'       => 'CouponController@sent_coupon_view'
        ]);
        $router->post('coupon-send', [
            'middleware' => 'auth',
            'as'         => 'merchant_send_coupon',
            'uses'       => 'CouponController@merchant_send_coupon'
        ]);

        // POS ITEM VARIANT
        $router->get('coupon-pos-item-variant-list/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_variant_list',
            'uses'       => 'CouponController@pos_item_variant_list'
        ]);

        // OTHERS
        $router->get('coupon/is-unique/{coupon_code}/{coupon_id}', [
            'middleware' => 'auth',
            'as'         => 'check_unique_coupon_code',
            'uses'       => 'CouponController@check_unique_coupon_code'
        ]);
        $router->get('coupon-group/is-unique/{coupon_group_code}/{coupon_group_id}', [
            'middleware' => 'auth',
            'as'         => 'check_unique_coupon_group_code',
            'uses'       => 'CouponController@check_unique_coupon_group_code'
        ]);
        $router->post('coupon-users', [
            'middleware' => 'auth',
            'as'         => 'coupon_users_edit',
            'uses'       => 'CouponController@coupon_users_edit'
        ]);
        $router->post('coupon-user/{coupon_user_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_user_edit',
            'uses'       => 'CouponController@coupon_user_edit'
        ]);

        // COUPON GROUP
        $router->get('coupon-group', [
            'middleware' => 'auth',
            'as'         => 'coupon_group_list',
            'uses'       => 'CouponController@coupon_group_list'
        ]);
        $router->get('coupon-group/{coupon_group_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_group_view',
            'uses'       => 'CouponController@coupon_group_view'
        ]);
        $router->post('coupon-group', [
            'middleware' => 'auth',
            'as'         => 'coupon_group_create',
            'uses'       => 'CouponController@coupon_group_create'
        ]);
        $router->post('coupon-group/{coupon_group_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_group_edit',
            'uses'       => 'CouponController@coupon_group_edit'
        ]);
        $router->delete('coupon-group/{coupon_group_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_group_delete',
            'uses'       => 'CouponController@coupon_group_delete'
        ]);
        $router->put('coupon-group-coupon', [
            'middleware' => 'auth',
            'as'         => 'coupon_group_coupon_edit',
            'uses'       => 'CouponController@coupon_group_coupon_edit'
        ]);
        $router->get('free-coupon-group', [
            'middleware' => 'auth',
            'as'         => 'get_free_coupon_groups',
            'uses'       => 'CouponController@get_free_coupon_groups'
        ]);
        $router->get('free-coupon-group/coupon', [
            'middleware' => 'auth',
            'as'         => 'get_coupons_by_group_id',
            'uses'       => 'CouponController@get_coupons_by_group_id'
        ]);

        $router->get('inv-item', [
            'middleware' => 'auth',
            'as'         => 'inv_item_list',
            'uses'       => 'InventoryController@inv_item_list'
        ]);
        $router->get('ingredient-item', [
            'middleware' => 'auth',
            'as'         => 'ingredient_item_list',
            'uses'       => 'InventoryController@ingredient_item_list'
        ]);
        $router->get('ingredient', [
            'middleware' => 'auth',
            'as'         => 'ingredient_list',
            'uses'       => 'InventoryController@ingredient_list'
        ]);
        $router->get('ingredient/{pos_item_ingredient_id}/{pos_item_id}/{pos_item_variant_id}', [
            'middleware' => 'auth',
            'as'         => 'ingredient_view',
            'uses'       => 'InventoryController@ingredient_view'
        ]);
        $router->get('ingredient/{pos_item_ingredient_id}', [
            'middleware' => 'auth',
            'as'         => 'ingredient_view',
            'uses'       => 'InventoryController@ingredient_view'
        ]);
        $router->post('ingredient', [
            'middleware' => 'auth',
            'as'         => 'ingredient_create',
            'uses'       => 'InventoryController@ingredient_create'
        ]);
        $router->put('ingredient/{pos_item_ingredient_id}', [
            'middleware' => 'auth',
            'as'         => 'ingredient_edit',
            'uses'       => 'InventoryController@ingredient_edit'
        ]);
        $router->delete('ingredient/{pos_item_ingredient_id}', [
            'middleware' => 'auth',
            'as'         => 'ingredient_delete',
            'uses'       => 'InventoryController@ingredient_delete'
        ]);

        // INV MATERIAL
        $router->get('inv-material', [
            'middleware' => 'auth',
            'as'         => 'inv_material_list',
            'uses'       => 'InventoryController@inv_material_list'
        ]);
        $router->get('inv-material/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_material_view',
            'uses'       => 'InventoryController@inv_material_view'
        ]);
        $router->post('inv-material', [
            'middleware' => 'auth',
            'as'         => 'inv_material_create',
            'uses'       => 'InventoryController@inv_material_create'
        ]);
        $router->post('inv-material/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_material_edit',
            'uses'       => 'InventoryController@inv_material_edit'
        ]);
        $router->delete('inv-material/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_material_delete',
            'uses'       => 'InventoryController@inv_material_delete'
        ]);

        // INV CATEGORY
        $router->get('inv-material-category', [
            'middleware' => 'auth',
            'as'         => 'inv_material_category_list',
            'uses'       => 'InventoryController@inv_material_category_list'
        ]);
        $router->get('inv-material-category/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_material_category_view',
            'uses'       => 'InventoryController@inv_material_category_view'
        ]);
        $router->post('inv-material-category', [
            'middleware' => 'auth',
            'as'         => 'inv_material_category_create',
            'uses'       => 'InventoryController@inv_material_category_create'
        ]);
        $router->put('inv-material-category/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_material_category_edit',
            'uses'       => 'InventoryController@inv_material_category_edit'
        ]);
        $router->delete('inv-material-category/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_material_category_delete',
            'uses'       => 'InventoryController@inv_material_category_delete'
        ]);

        // INV SLOC
        $router->get('inv-sloc', [
            'middleware' => 'auth',
            'as'         => 'get_inv_sloc',
            'uses'       => 'InventoryController@get_inv_sloc'
        ]);
        $router->put('inv-sloc', [
            'middleware' => 'auth',
            'as'         => 'set_inv_sloc',
            'uses'       => 'InventoryController@set_inv_sloc'
        ]);

        // INV UNIT
        $router->get('inv-unit', [
            'middleware' => 'auth',
            'as'         => 'inv_unit_list',
            'uses'       => 'InventoryController@inv_unit_list'
        ]);

        // INV STOCK ADJUSTMENT
        $router->get('inv-stock-adjustment', [
            'middleware' => 'auth',
            'as'         => 'inv_stock_adjustment_list',
            'uses'       => 'InventoryController@inv_stock_adjustment_list'
        ]);
        $router->get('inv-stock-adjustment/{inv_stock_trx_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_stock_adjustment_view',
            'uses'       => 'InventoryController@inv_stock_adjustment_view'
        ]);
        $router->post('inv-stock-adjustment', [
            'middleware' => 'auth',
            'as'         => 'inv_stock_adjustment_create',
            'uses'       => 'InventoryController@inv_stock_adjustment_create'
        ]);
        $router->delete('inv-stock-adjustment/{inv_stock_trx_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_stock_adjustment_delete',
            'uses'       => 'InventoryController@inv_stock_adjustment_delete'
        ]);

        // INV STOCK IN
        $router->post('inv-stock-in', [
            'middleware' => 'auth',
            'as'         => 'inv_stock_in_create',
            'uses'       => 'InventoryController@inv_stock_in_create'
        ]);
        $router->post('inv-stock-out', [
            'middleware' => 'auth',
            'as'         => 'inv_stock_out_create',
            'uses'       => 'InventoryController@inv_stock_out_create'
        ]);

        // INV TRANSFER IN
        $router->get('inv-transfer-in', [
            'middleware' => 'auth',
            'as' => 'inv_transfer_in_list',
            'uses' => 'InventoryController@inv_transfer_in_list'
        ]);
        $router->get('inv-transfer-in/{inv_stock_trf_head_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_transfer_in_view',
            'uses'       => 'InventoryController@inv_transfer_in_view'
        ]);
        $router->post('inv-transfer-in', [
            'middleware' => 'auth',
            'as'         => 'inv_transfer_in_create',
            'uses'       => 'InventoryController@inv_transfer_in_create'
        ]);

        // INV TRANSFER OUT
        $router->get('inv-transfer-out', [
            'middleware' => 'auth',
            'as'         => 'inv_transfer_out_list',
            'uses'       => 'InventoryController@inv_transfer_out_list'
        ]);
        $router->get('inv-transfer-out/{inv_stock_trf_head_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_transfer_out_view',
            'uses'       => 'InventoryController@inv_transfer_out_view'
        ]);
        $router->post('inv-transfer-out', [
            'middleware' => 'auth',
            'as'         => 'inv_transfer_out_create',
            'uses'       => 'InventoryController@inv_transfer_out_create'
        ]);

        // INV VENDOR
        $router->get('inv-vendor', [
            'middleware' => 'auth',
            'as'         => 'inv_vendor_list',
            'uses'       => 'InventoryController@inv_vendor_list'
        ]);
        $router->get('inv-vendor/{inv_vendor_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_vendor_view',
            'uses'       => 'InventoryController@inv_vendor_view'
        ]);
        $router->post('inv-vendor', [
            'middleware' => 'auth',
            'as'         => 'inv_vendor_create',
            'uses'       => 'InventoryController@inv_vendor_create'
        ]);
        $router->post('inv-vendor/{inv_vendor_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_vendor_edit',
            'uses'       => 'InventoryController@inv_vendor_edit'
        ]);
        $router->delete('inv-vendor/{inv_vendor_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_vendor_delete',
            'uses'       => 'InventoryController@inv_vendor_delete'
        ]);

        // INV PURCHASE ORDER
        $router->get('inv-purchase-order', [
            'middleware' => 'auth',
            'as'         => 'inv_purchase_order_list',
            'uses'       => 'InventoryController@inv_purchase_order_list'
        ]);
        $router->get('inv-purchase-order/{inv_purchase_order_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_purchase_order_view',
            'uses'       => 'InventoryController@inv_purchase_order_view'
        ]);
        $router->post('inv-purchase-order', [
            'middleware' => 'auth',
            'as'         => 'inv_purchase_order_create',
            'uses'       => 'InventoryController@inv_purchase_order_create'
        ]);
        $router->post('inv-purchase-order/{inv_purchase_order_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_purchase_order_edit',
            'uses'       => 'InventoryController@inv_purchase_order_edit'
        ]);
        $router->delete('inv-purchase-order/{inv_purchase_order_id}', [
            'middleware' => 'auth',
            'as'         => 'inv_purchase_order_delete',
            'uses'       => 'InventoryController@inv_purchase_order_delete'
        ]);

        // INV REPORT
        $router->post('report/inv-stock-transaction', [
            'middleware' => 'auth',
            'as'         => 'retrieve_inv_transaction_list',
            'uses'       => 'InventoryController@retrieve_inv_transaction_list'
        ]);

        $router->get('inventory/search-item', [
            'middleware' => 'auth',
            'as' => 'search_item',
            'uses' => 'InventoryController@search_item'
        ]);
        $router->get('inventory/current-stock', [
            'middleware' => 'auth',
            'as' => 'check_current_stock',
            'uses' => 'InventoryController@check_current_stock'
        ]);
        $router->get('inventory/get-inv-stock-trx-local-trx-id', [
            'middleware' => 'auth',
            'as' => 'get_inv_stock_trx_local_trx_id',
            'uses' => 'InventoryController@get_inv_stock_trx_local_trx_id'
        ]);

        // LOG REPORT
        $router->post('report/deleted-sales-item', [
            'middleware' => 'auth',
            'as'         => 'retrieve_deleted_sales_item',
            'uses'       => 'LogReportController@retrieve_deleted_sales_item'
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
        $router->get('referral-reward', [
            'middleware' => 'auth',
            'as'         => 'get_referral_reward',
            'uses'       => 'LoyaltyController@get_referral_reward'
        ]);
        $router->post('referral-reward', [
            'middleware' => 'auth',
            'as'         => 'set_referral_reward',
            'uses'       => 'LoyaltyController@set_referral_reward'
        ]);

        // BIRTHDAY REWARD
        $router->get('birthday-reward', [
            'middleware' => 'auth',
            'as'         => 'get_birthday_reward',
            'uses'       => 'LoyaltyController@get_birthday_reward'
        ]);
        $router->put('birthday-reward', [
            'middleware' => 'auth',
            'as'         => 'set_birthday_reward',
            'uses'       => 'LoyaltyController@set_birthday_reward'
        ]);

        // REWARD COUPON
        $router->put('reward-coupon', [
            'middleware' => 'auth',
            'as'         => 'reward_coupon_edit',
            'uses'       => 'LoyaltyController@reward_coupon_edit'
        ]);

        // BLAST REWARD
        $router->post('member/info', [
            'middleware' => 'auth',
            'as'         => 'member_info',
            'uses'       => 'LoyaltyController@member_info'
        ]);
        $router->get('blast-reward', [
            'middleware' => 'auth',
            'as'         => 'blast_reward_list',
            'uses'       => 'LoyaltyController@blast_reward_list'
        ]);
        $router->post('blast-reward', [
            'middleware' => 'auth',
            'as'         => 'blast_reward_create',
            'uses'       => 'LoyaltyController@blast_reward_create'
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
        $router->put('membership-up/{business_membership_id}', [
            'middleware' => 'auth',
            'as'         => 'membership_up',
            'uses'       => 'MembershipController@membership_up'
        ]);
        $router->put('membership-down/{business_membership_id}', [
            'middleware' => 'auth',
            'as'         => 'membership_down',
            'uses'       => 'MembershipController@membership_down'
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

        // POS ITEM
        $router->get('pos-item', [
            'middleware' => 'auth',
            'as'         => 'pos_item_list',
            'uses'       => 'PosController@pos_item_list'
        ]);
        $router->get('pos-item/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_view',
            'uses'       => 'PosController@pos_item_view'
        ]);
        $router->put('pos-item-up/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_up',
            'uses'       => 'PosController@pos_item_up'
        ]);
        $router->put('pos-item-down/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_down',
            'uses'       => 'PosController@pos_item_down'
        ]);
        $router->post('pos-item', [
            'middleware' => 'auth',
            'as'         => 'pos_item_create',
            'uses'       => 'PosController@pos_item_create'
        ]);
        $router->post('pos-item/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_edit',
            'uses'       => 'PosController@pos_item_edit'
        ]);
        $router->delete('pos-item/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_delete',
            'uses'       => 'PosController@pos_item_delete'
        ]);
        $router->delete('pos-items', [
            'middleware' => 'auth',
            'as'         => 'pos_items_delete',
            'uses'       => 'PosController@pos_items_delete'
        ]);

        $router->get('sku/is-unique/{sku}/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'check_unique_variant_sku',
            'uses'       => 'PosController@check_unique_variant_sku'
        ]);

        $router->put('commission-worker-profile-detail', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_profile_detail_edit',
            'uses'       => 'PosController@commission_worker_profile_detail_edit'
        ]);

        // POS ITEM CATEGORY
        $router->get('pos-item-category', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_list',
            'uses'       => 'PosController@pos_item_category_list'
        ]);
        $router->get('pos-item-category/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_view',
            'uses'       => 'PosController@pos_item_category_view'
        ]);
        $router->put('pos-item-category-up/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_up',
            'uses'       => 'PosController@pos_item_category_up'
        ]);
        $router->put('pos-item-category-down/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_down',
            'uses'       => 'PosController@pos_item_category_down'
        ]);
        $router->post('pos-item-category', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_create',
            'uses'       => 'PosController@pos_item_category_create'
        ]);
        $router->put('pos-item-category/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_edit',
            'uses'       => 'PosController@pos_item_category_edit'
        ]);
        $router->delete('pos-item-category/{pos_item_category_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_category_delete',
            'uses'       => 'PosController@pos_item_category_delete'
        ]);

        // POS ITEM MODIFIER
        $router->get('pos-item-modifier', [
            'middleware' => 'auth',
            'as'         => 'pos_item_modifier_list',
            'uses'       => 'PosController@pos_item_modifier_list'
        ]);
        $router->get('pos-item-modifier/{pos_item_modifier_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_modifier_view',
            'uses'       => 'PosController@pos_item_modifier_view'
        ]);
        $router->post('pos-item-modifier', [
            'middleware' => 'auth',
            'as'         => 'pos_item_modifier_create',
            'uses'       => 'PosController@pos_item_modifier_create'
        ]);
        $router->put('pos-item-modifier/{pos_item_modifier_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_modifier_edit',
            'uses'       => 'PosController@pos_item_modifier_edit'
        ]);
        $router->delete('pos-item-modifier/{pos_item_modifier_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_modifier_delete',
            'uses'       => 'PosController@pos_item_modifier_delete'
        ]);
        $router->put('pos-item-modifier-option', [
            'middleware' => 'auth',
            'as'         => 'pos_item_modifier_option_edit',
            'uses'       => 'PosController@pos_item_modifier_option_edit'
        ]);
        $router->put('pos-item-pos-item-modifier', [
            'middleware' => 'auth',
            'as'         => 'pos_item_pos_item_modifier_edit',
            'uses'       => 'PosController@pos_item_pos_item_modifier_edit'
        ]);

        // POS ITEM DISCOUNT
        $router->get('pos-item-discount', [
            'middleware' => 'auth',
            'as'         => 'pos_item_discount_list',
            'uses'       => 'PosController@pos_item_discount_list'
        ]);
        $router->get('pos-item-discount/{pos_item_discount_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_discount_view',
            'uses'       => 'PosController@pos_item_discount_view'
        ]);
        $router->post('pos-item-discount', [
            'middleware' => 'auth',
            'as'         => 'pos_item_discount_create',
            'uses'       => 'PosController@pos_item_discount_create'
        ]);
        $router->put('pos-item-discount/{pos_item_discount_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_discount_edit',
            'uses'       => 'PosController@pos_item_discount_edit'
        ]);
        $router->delete('pos-item-discount/{pos_item_discount_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_discount_delete',
            'uses'       => 'PosController@pos_item_discount_delete'
        ]);

        // POS ITEM PACKAGE
        $router->get('pos-item-package', [
            'middleware' => 'auth',
            'as'         => 'pos_item_package_list',
            'uses'       => 'PosController@pos_item_package_list'
        ]);
        $router->get('pos-item-package/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_package_view',
            'uses'       => 'PosController@pos_item_package_view'
        ]);
        $router->post('pos-item-package', [
            'middleware' => 'auth',
            'as'         => 'pos_item_package_create',
            'uses'       => 'PosController@pos_item_package_create'
        ]);
        $router->post('pos-item-package/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_package_edit',
            'uses'       => 'PosController@pos_item_package_edit'
        ]);
        $router->delete('pos-item-package/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_package_delete',
            'uses'       => 'PosController@pos_item_package_delete'
        ]);

        // POS ITEM PACKAGE DETAIL
        $router->put('pos-item-package', [
            'middleware' => 'auth',
            'as'         => 'pos_item_package_detail_edit',
            'uses'       => 'PosController@pos_item_package_detail_edit'
        ]);

        // POS ITEM VARIANT
        $router->get('pos-item-variant-list/{pos_item_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_variant_list',
            'uses'       => 'PosController@pos_item_variant_list'
        ]);
        $router->get('pos-item-variant/{pos_item_variant_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_item_variant_view',
            'uses'       => 'PosController@pos_item_variant_view'
        ]);
        $router->put('pos-item-variant', [
            'middleware' => 'auth',
            'as'         => 'pos_item_variant_edit',
            'uses'       => 'PosController@pos_item_variant_edit'
        ]);

        //POS ITEM INGREDIENT
        $router->put('pos-item-ingredient', [
            'middleware' => 'auth',
            'as'         => 'pos_item_ingredient_edit',
            'uses'       => 'PosController@pos_item_ingredient_edit'
        ]);

        // POS PAYMENT METHOD
        $router->get('all-pos-payment-method', [
            'middleware' => 'auth',
            'as'         => 'all_pos_payment_method_list',
            'uses'       => 'PosController@all_pos_payment_method_list'
        ]);
        $router->get('pos-payment-method', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_list',
            'uses'       => 'PosController@pos_payment_method_list'
        ]);
        $router->get('pos-payment-method/{pos_payment_method_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_view',
            'uses'       => 'PosController@pos_payment_method_view'
        ]);
        $router->put('pos-payment-method-up/{pos_payment_method_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_up',
            'uses'       => 'PosController@pos_payment_method_up'
        ]);
        $router->put('pos-payment-method-down/{pos_payment_method_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_down',
            'uses'       => 'PosController@pos_payment_method_down'
        ]);
        $router->post('pos-payment-method', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_create',
            'uses'       => 'PosController@pos_payment_method_create'
        ]);
        $router->put('pos-payment-method/{pos_payment_method_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_edit',
            'uses'       => 'PosController@pos_payment_method_edit'
        ]);
        $router->delete('pos-payment-method/{pos_payment_method_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_payment_method_delete',
            'uses'       => 'PosController@pos_payment_method_delete'
        ]);

        // POS TAX
        $router->get('pos-tax', [
            'middleware' => 'auth',
            'as'         => 'pos_tax_view',
            'uses'       => 'PosController@pos_tax_view'
        ]);
        $router->post('pos-tax', [
            'middleware' => 'auth',
            'as'         => 'pos_tax_create',
            'uses'       => 'PosController@pos_tax_create'
        ]);
        $router->put('pos-tax', [
            'middleware' => 'auth',
            'as'         => 'pos_tax_edit',
            'uses'       => 'PosController@pos_tax_edit'
        ]);
        $router->delete('pos-tax/{pos_tax_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_tax_delete',
            'uses'       => 'PosController@pos_tax_delete'
        ]);

        $router->put('pos-tax-exception-outlet', [
            'middleware' => 'auth',
            'as'         => 'pos_tax_exception_outlet_edit',
            'uses'       => 'PosController@pos_tax_exception_outlet_edit'
        ]);

        // POS SERVICE CHARGE
        $router->get('pos-service-charge', [
            'middleware' => 'auth',
            'as'         => 'pos_service_charge_list',
            'uses'       => 'PosController@pos_service_charge_list'
        ]);
        $router->get('pos-service-charge/{pos_serviceCharge_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_service_charge_view',
            'uses'       => 'PosController@pos_service_charge_view'
        ]);
        $router->post('pos-service-charge', [
            'middleware' => 'auth',
            'as'         => 'pos_service_charge_create',
            'uses'       => 'PosController@pos_service_charge_create'
        ]);
        $router->put('pos-service-charge/{pos_serviceCharge_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_service_charge_edit',
            'uses'       => 'PosController@pos_service_charge_edit'
        ]);
        $router->delete('pos-service-charge/{pos_serviceCharge_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_service_charge_delete',
            'uses'       => 'PosController@pos_service_charge_delete'
        ]);

        $router->put('pos-service-charge-exception-outlet', [
            'middleware' => 'auth',
            'as'         => 'pos_service_charge_exception_outlet_edit',
            'uses'       => 'PosController@pos_service_charge_exception_outlet_edit'
        ]);

        // POS ADDITIONAL CHARGE
        $router->get('pos-additional-charge', [
            'middleware' => 'auth',
            'as'         => 'pos_additional_charge_list',
            'uses'       => 'PosController@pos_additional_charge_list'
        ]);
        $router->get('pos-additional-charge/{pos_additionalCharge_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_additional_charge_view',
            'uses'       => 'PosController@pos_additional_charge_view'
        ]);
        $router->post('pos-additional-charge', [
            'middleware' => 'auth',
            'as'         => 'pos_additional_charge_create',
            'uses'       => 'PosController@pos_additional_charge_create'
        ]);
        $router->put('pos-additional-charge/{pos_additionalCharge_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_additional_charge_edit',
            'uses'       => 'PosController@pos_additional_charge_edit'
        ]);
        $router->delete('pos-additional-charge/{pos_additionalCharge_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_additional_charge_delete',
            'uses'       => 'PosController@pos_additional_charge_delete'
        ]);

        $router->put('pos-additional-charge-exception-outlet', [
            'middleware' => 'auth',
            'as'         => 'pos_additional_charge_exception_outlet_edit',
            'uses'       => 'PosController@pos_additional_charge_exception_outlet_edit'
        ]);

        // POS SALES TYPE
        $router->get('pos-sales-type', [
            'middleware' => 'auth',
            'as'         => 'pos_sales_type_list',
            'uses'       => 'PosController@pos_sales_type_list'
        ]);
        $router->get('pos-sales-type/{pos_salesType_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_sales_type_view',
            'uses'       => 'PosController@pos_sales_type_view'
        ]);
        $router->post('pos-sales-type', [
            'middleware' => 'auth',
            'as'         => 'pos_sales_type_create',
            'uses'       => 'PosController@pos_sales_type_create'
        ]);
        $router->put('pos-sales-type/{pos_salesType_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_sales_type_edit',
            'uses'       => 'PosController@pos_sales_type_edit'
        ]);
        $router->delete('pos-sales-type/{pos_salesType_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_sales_type_delete',
            'uses'       => 'PosController@pos_sales_type_delete'
        ]);

        // POS ORDER PRINT OUT SECTION
        $router->get('pos-order-print-out-section', [
            'middleware' => 'auth',
            'as'         => 'pos_order_print_out_section_list',
            'uses'       => 'PosController@pos_order_print_out_section_list'
        ]);
        $router->get('pos-order-print-out-section/{pos_order_print_out_section_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_order_print_out_section_view',
            'uses'       => 'PosController@pos_order_print_out_section_view'
        ]);
        $router->post('pos-order-print-out-section', [
            'middleware' => 'auth',
            'as'         => 'pos_order_print_out_section_create',
            'uses'       => 'PosController@pos_order_print_out_section_create'
        ]);
        $router->put('pos-order-print-out-section/{pos_order_print_out_section_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_order_print_out_section_edit',
            'uses'       => 'PosController@pos_order_print_out_section_edit'
        ]);
        $router->delete('pos-order-print-out-section/{pos_order_print_out_section_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_order_print_out_section_delete',
            'uses'       => 'PosController@pos_order_print_out_section_delete'
        ]);

        // POS AREA CATEGORY
        $router->get('pos-area-category', [
            'middleware' => 'auth',
            'as'         => 'pos_areaCategory_list',
            'uses'       => 'PosController@pos_areaCategory_list'
        ]);
        $router->get('pos-area-category/{pos_areaCategory_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_areaCategory_view',
            'uses'       => 'PosController@pos_areaCategory_view'
        ]);
        $router->post('pos-area-category', [
            'middleware' => 'auth',
            'as'         => 'pos_areaCategory_create',
            'uses'       => 'PosController@pos_areaCategory_create'
        ]);
        $router->put('pos-area-category/{pos_areaCategory_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_areaCategory_edit',
            'uses'       => 'PosController@pos_areaCategory_edit'
        ]);
        $router->delete('pos-area-category/{pos_areaCategory_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_areaCategory_delete',
            'uses'       => 'PosController@pos_areaCategory_delete'
        ]);

        // POS AREA
        $router->get('pos-area', [
            'middleware' => 'auth',
            'as'         => 'pos_area_list',
            'uses'       => 'PosController@pos_area_list'
        ]);
        $router->get('pos-area/{pos_area_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_area_view',
            'uses'       => 'PosController@pos_area_view'
        ]);
        $router->post('pos-area', [
            'middleware' => 'auth',
            'as'         => 'pos_area_create',
            'uses'       => 'PosController@pos_area_create'
        ]);
        $router->put('pos-area/{pos_area_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_area_edit',
            'uses'       => 'PosController@pos_area_edit'
        ]);
        $router->delete('pos-area/{pos_area_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_area_delete',
            'uses'       => 'PosController@pos_area_delete'
        ]);

        // POS TAG
        $router->get('pos-tag', [
            'middleware' => 'auth',
            'as'         => 'pos_tag_list',
            'uses'       => 'PosController@pos_tag_list'
        ]);
        $router->get('pos-tag/{pos_tag_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_tag_view',
            'uses'       => 'PosController@pos_tag_view'
        ]);
        $router->post('pos-tag', [
            'middleware' => 'auth',
            'as'         => 'pos_tag_create',
            'uses'       => 'PosController@pos_tag_create'
        ]);
        $router->put('pos-tag/{pos_tag_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_tag_edit',
            'uses'       => 'PosController@pos_tag_edit'
        ]);
        $router->delete('pos-tag/{pos_tag_id}', [
            'middleware' => 'auth',
            'as'         => 'pos_tag_delete',
            'uses'       => 'PosController@pos_tag_delete'
        ]);

        // POS SALES TRX
        $router->get('report/pos/detail/{pos_sales_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_transaction',
            'uses' => 'PosSalesTrxController@retrieve_pos_transaction'
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

        // COMMISSION OMZET
        $router->get('commission-omzet', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_list',
            'uses'       => 'ReportController@commission_omzet_list'
        ]);
        $router->get('commission-omzet/{commission_omzet_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_view',
            'uses'       => 'ReportController@commission_omzet_view'
        ]);
        $router->post('commission-omzet', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_create',
            'uses'       => 'ReportController@commission_omzet_create'
        ]);
        $router->delete('commission-omzet/{commission_omzet_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_omzet_delete',
            'uses'       => 'ReportController@commission_omzet_delete'
        ]);

        // COMMISSION SELLER OMZET
        $router->get('commission-seller-omzet', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_list',
            'uses'       => 'ReportController@commission_seller_omzet_list'
        ]);
        $router->get('commission-seller-omzet/{commission_omzet_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_view',
            'uses'       => 'ReportController@commission_seller_omzet_view'
        ]);
        $router->post('commission-seller-omzet', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_create',
            'uses'       => 'ReportController@commission_seller_omzet_create'
        ]);
        $router->delete('commission-seller-omzet/{commission_omzet_id}', [
            'middleware' => 'auth',
            'as'         => 'commission_seller_omzet_delete',
            'uses'       => 'ReportController@commission_seller_omzet_delete'
        ]);

        // POS SALES TRX
        $router->get('report/pos/pos-trx', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_list',
            'uses' => 'ReportController@pos_sales_trx_list'
        ]);
        $router->get('report/pos/pos-trx-detail', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_detail_list',
            'uses' => 'ReportController@pos_sales_trx_detail_list'
        ]);
        $router->get('report/pos/pos-sales-item-summary', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_item_summary',
            'uses' => 'ReportController@retrieve_pos_sales_item_summary'
        ]);

        // POS SALES TRX COMMISSION
        $router->get('report/pos/pos-sales-trx-commission-by-trx', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_trx_commission_by_trx',
            'uses' => 'ReportController@retrieve_pos_sales_trx_commission_by_trx'
        ]);
        $router->get('report/pos/pos-sales-trx-commission', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_trx_commission',
            'uses' => 'ReportController@retrieve_pos_sales_trx_commission'
        ]);
        $router->get('report/pos/pos-sales-trx-commission-summary', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_trx_commission_summary',
            'uses' => 'ReportController@retrieve_pos_sales_trx_commission_summary'
        ]);

        // OMZET RECAPITULATION
        $router->get('report/pos/omzet-recapitulation', [
            'middleware' => 'auth',
            'as' => 'retrieve_omzet_recapitulation',
            'uses' => 'ReportController@retrieve_omzet_recapitulation'
        ]);

        // COMMISSION WORKER
        $router->post('report/pos/business-commission-worker', [
            'middleware' => 'auth',
            'as'         => 'retrieve_commission_worker',
            'uses'       => 'ReportController@retrieve_commission_worker'
        ]);

        // DOWNLOAD
        $router->get('report/pos/commission-worker-report-download', [
            'middleware' => 'auth',
            'as'         => 'commission_worker_report_download',
            'uses'       => 'ReportController@commission_worker_report_download'
        ]);
        $router->get('report/pos/monthly-worker-report-download', [
            'middleware' => 'auth',
            'as'         => 'get_monthly_worker_report',
            'uses'       => 'CustomReportController@get_monthly_worker_report'
        ]);

        // REDEEM BLOCKER
        $router->get('redeem-blocker', [
            'middleware' => 'auth',
            'as'         => 'get_redeem_blocker',
            'uses'       => 'RewardController@get_redeem_blocker'
        ]);
        $router->post('redeem-blocker', [
            'middleware' => 'auth',
            'as'         => 'set_redeem_blocker',
            'uses'       => 'RewardController@set_redeem_blocker'
        ]);
        $router->get('redeem-blocker-statistic', [
            'middleware' => 'auth',
            'as'         => 'retrieve_redeem_blocker_statistic_list',
            'uses'       => 'RewardController@retrieve_redeem_blocker_statistic_list'
        ]);
        $router->post('blocked-member', [
            'middleware' => 'auth',
            'as'         => 'retrieve_blocked_member_list',
            'uses'       => 'RewardController@retrieve_blocked_member_list'
        ]);
        $router->put('redeem-block-status', [
            'middleware' => 'auth',
            'as'         => 'redeem_block_status_edit',
            'uses'       => 'RewardController@redeem_block_status_edit'
        ]);
        $router->put('unblock-permanent', [
            'middleware' => 'auth',
            'as'         => 'unblock_permanent',
            'uses'       => 'RewardController@unblock_permanent'
        ]);
        $router->put('unblock-temporary', [
            'middleware' => 'auth',
            'as'         => 'unblock_temporary',
            'uses'       => 'RewardController@unblock_temporary'
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
        $router->delete('reward/{reward_id}', [
            'middleware' => 'auth',
            'as'         => 'reward_delete',
            'uses'       => 'RewardController@reward_delete'
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

        // TRANSACTION
        $router->post('pos/loyalty/transaction/void/{loyalty_trx_head_id}', [
            'middleware'=>'auth',
            'as'=>'void_loyalty_transaction',
            'uses'=>'TransactionController@void_loyalty_transaction'
        ]);
        $router->post('pos/reward/transaction/void/{reward_trx_head_id}', [
            'middleware'=>'auth',
            'as'=>'void_reward_transaction',
            'uses'=>'TransactionController@void_reward_transaction'
        ]);
        $router->post('pos/membership/transaction/void/{business_membership_trx_id}', [
            'middleware' => 'auth',
            'as' => 'void_membership_transaction',
            'uses' => 'TransactionController@void_membership_transaction'
        ]);
        $router->post('pos/coupon/transaction/void/{coupon_trx_head_id}', [
            'middleware'=>'auth',
            'as'=>'void_coupon_transaction',
            'uses'=>'TransactionController@void_coupon_transaction'
        ]);
        $router->post('pos/coupon-redeem/transaction/void/{coupon_trx_redeem_id}', [
            'middleware'=>'auth',
            'as'=>'void_coupon_redeem_transaction',
            'uses'=>'TransactionController@void_coupon_redeem_transaction'
        ]);
        $router->post('pos/wallet/transaction/void/{businessWallet_trx_id}', [
            'middleware' => 'auth',
            'as' => 'void_wallet_transaction',
            'uses' => 'TransactionController@void_wallet_transaction'
        ]);
        $router->post('pos/transaction/void/{pos_sales_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'void_pos_sales_trx',
            'uses' => 'TransactionController@void_pos_sales_trx'
        ]);
        $router->post('inventory/transfer-out/void/{inv_stock_trf_head_id}', [
            'middleware' => 'auth',
            'as' => 'void_inv_transfer_out',
            'uses' => 'TransactionController@void_inv_transfer_out'
        ]);

        // WALLET
        $router->get('wallet', [
            'middleware' => 'auth',
            'as'         => 'get_business_wallets',
            'uses'       => 'WalletController@get_business_wallets'
        ]);
        $router->put('wallet', [
            'middleware' => 'auth',
            'as'         => 'wallet_edit',
            'uses'       => 'WalletController@wallet_edit'
        ]);

        // TOP UP REWARD RULE
        $router->get('top-up-reward-rule', [
            'middleware' => 'auth',
            'as'         => 'top_up_reward_rule_list',
            'uses'       => 'WalletController@top_up_reward_rule_list'
        ]);
        $router->get('top-up-reward-rule/{top_up_reward_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'top_up_reward_rule_view',
            'uses'       => 'WalletController@top_up_reward_rule_view'
        ]);
        $router->post('top-up-reward-rule', [
            'middleware' => 'auth',
            'as'         => 'top_up_reward_rule_create',
            'uses'       => 'WalletController@top_up_reward_rule_create'
        ]);
        $router->post('top-up-reward-rule/{top_up_reward_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'top_up_reward_rule_edit',
            'uses'       => 'WalletController@top_up_reward_rule_edit'
        ]);
        $router->delete('top-up-reward-rule/{top_up_reward_rule_id}', [
            'middleware' => 'auth',
            'as'         => 'top_up_reward_rule_delete',
            'uses'       => 'WalletController@top_up_reward_rule_delete'
        ]);

        // WEBHOOK
        $router->post('report/telegram-user-report-webhook', [
            'as' => 'telegram_user_report_webhook',
            'uses' => 'WebhookController@telegram_user_report_webhook'
        ]);
        $router->post('report/line-user-report-webhook', [
            'as' => 'line_user_report_webhook',
            'uses' => 'WebhookController@line_user_report_webhook'
        ]);

        // OTHERS
        $router->get('currency', [
            'middleware' => 'auth',
            'as'         => 'currency_list',
            'uses'       => 'PosController@currency_list'
        ]);
    });
});

$router->group(['prefix' => 'merchant'], function () use ($router) {

    $router->get('city', [
        'as'   => 'get_cities',
        'uses' => 'GeneralController@get_cities'
    ]);

    $router->get('city-by-postal-code', [
        'as'   => 'get_city_id',
        'uses' => 'GeneralController@get_city_id'
    ]);

    $router->get('place', [
        'as'   => 'get_places',
        'uses' => 'GeneralController@get_places'
    ]);

    $router->get('building', [
        'as'   => 'get_buildings',
        'uses' => 'GeneralController@get_buildings'
    ]);

    $router->get('phone-type', [
        'as'   => 'get_phone_types',
        'uses' => 'GeneralController@get_phone_types'
    ]);

    $router->get('socialmedia', [
        'as'   => 'get_socialmedias',
        'uses' => 'GeneralController@get_socialmedias'
    ]);

    $router->get('service', [
        'as'   => 'get_services',
        'uses' => 'GeneralController@get_services'
    ]);

    $router->get('day', [
        'as'   => 'get_days',
        'uses' => 'GeneralController@get_days'
    ]);

    $router->get('category', [
        'as'   => 'get_categories',
        'uses' => 'GeneralController@get_categories'
    ]);

    $router->get('next', [
        'middleware' => 'auth',
        'as'   => 'get_next_id',
        'uses' => 'GeneralController@get_next_id'
    ]);

    // AUTH
    $router->post('auth/sign-in', [
        'uses' => 'AuthController@business_user_signin'
    ]);
    $router->get('auth/sign-out', [
        'middleware' => 'auth',
        'as' => 'sign_out',
        'uses' => 'MerchantController@sign_out'
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
    $router->get('reward_type', [
        'middleware' => 'auth',
        'as'         => 'reward_type_list',
        'uses'       => 'MerchantController@reward_type_list'
    ]);
    $router->get('promo-day/{promo_id}', [
        'middleware' => 'auth',
        'as'         => 'promo_day_view',
        'uses'       => 'MerchantController@promo_day_view'
    ]);
//    $router->get('promo', [
//        'middleware' => 'auth',
//        'as'         => 'business_promo_list',
//        'uses'       => 'MerchantController@business_promo_list'
//    ]);
    $router->get('member', [
        'middleware' => 'auth',
        'as'         => 'membership_user_list',
        'uses'       => 'MerchantController@membership_user_list'
    ]);
    $router->post('user/info', [
        'middleware' => 'auth',
        'as' => 'user_info',
        'uses' => 'MerchantController@user_info'
    ]);
    $router->post('user/edit', [
        'middleware' => 'auth',
        'as' => 'edit_user_data',
        'uses' => 'MerchantController@edit_user_data'
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
    $router->get('update-user-phone-email/{mass_activation_id}', [
        'as'   => 'update_user_phone_email',
        'uses' => 'MerchantController@update_user_phone_email'
    ]);
});

$router->group(['namespace' => 'Office'], function () use ($router) {
    $router->group(['prefix' => 'merchant'], function () use ($router) {
        // BUSINESS USER AUTH ACCESS
        $router->get('auth-access', [
            'middleware' => 'auth',
            'as'         => 'business_user_auth_access_list',
            'uses'       => 'BusinessUserController@business_user_auth_access_list'
        ]);
        $router->get('cashier-auth-access', [
            'middleware' => 'auth',
            'as'         => 'cashier_business_user_auth_access_list',
            'uses'       => 'BusinessUserController@cashier_business_user_auth_access_list'
        ]);
    });
});