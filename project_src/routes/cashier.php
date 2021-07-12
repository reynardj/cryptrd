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
// CASHIER
// *******

$router->group(['namespace' => 'Cashier'], function () use ($router) {
    $router->group(['prefix' => 'cashier'], function () use ($router) {
        // COUPON
        $router->get('coupon/get', [
            'middleware' => 'auth',
            'as' => 'get_coupons',
            'uses' => 'CouponController@get_coupons'
        ]);
        $router->get('coupon-group/get', [
            'middleware' => 'auth',
            'as' => 'get_coupon_groups',
            'uses' => 'CouponController@get_coupon_groups'
        ]);
        $router->get('coupon-list', [
            'middleware' => 'auth',
            'as' => 'get_coupon_list',
            'uses' => 'CouponController@get_coupon_list'
        ]);
        $router->post('coupon/send', [
            'middleware' => 'auth',
            'as' => 'send_coupon',
            'uses' => 'CouponController@send_coupon'
        ]);
        $router->post('coupon/send/preview', [
            'middleware' => 'auth',
            'as' => 'send_coupon_preview',
            'uses' => 'CouponController@send_coupon_preview'
        ]);
        $router->post('coupon/redeem/preview', [
            'middleware' => 'auth',
            'as' => 'redeem_coupon_preview',
            'uses' => 'CouponController@redeem_coupon_preview'
        ]);
        $router->post('coupon/redeem', [
            'middleware' => 'auth',
            'as' => 'redeem_coupon',
            'uses' => 'CouponController@redeem_coupon'
        ]);
        $router->post('coupon/direct-redeem/preview', [
            'middleware' => 'auth',
            'as' => 'direct_redeem_coupon_preview',
            'uses' => 'CouponController@direct_redeem_coupon_preview'
        ]);
        $router->post('coupon/direct-redeem', [
            'middleware' => 'auth',
            'as' => 'redeem_coupon',
            'uses' => 'CouponController@direct_redeem_coupon'
        ]);
        $router->post('coupon/save-redeem', [
            'middleware' => 'auth',
            'as' => 'save_redeem_coupon',
            'uses' => 'CouponController@save_redeem_coupon'
        ]);
        $router->get('pos/coupon/transaction/list', [
            'middleware' => 'auth',
            'as'=>'retrieve_coupon_transactions',
            'uses'=>'CouponController@retrieve_coupon_transactions'
        ]);
        $router->get('pos/coupon-redeem/transaction/list', [
            'middleware' => 'auth',
            'as'=>'retrieve_coupon_redeem_transactions',
            'uses'=>'CouponController@retrieve_coupon_redeem_transactions'
        ]);
        $router->get('pos/coupon/transaction/web-list', [
            'middleware' => 'auth',
            'as'=>'retrieve_coupon_transactions_for_web',
            'uses'=>'CouponController@retrieve_coupon_transactions_for_web'
        ]);
        $router->get('pos/coupon-redeem/transaction/web-list', [
            'middleware' => 'auth',
            'as'=>'retrieve_coupon_redeem_transactions_for_web',
            'uses'=>'CouponController@retrieve_coupon_redeem_transactions_for_web'
        ]);
        $router->post('pos/coupon/transaction/void/{coupon_trx_head_id}', [
            'middleware' => 'auth',
            'as'=>'void_coupon_transaction',
            'uses'=>'CouponController@void_coupon_transaction'
        ]);
        $router->post('pos/coupon-redeem/transaction/void/{coupon_trx_redeem_id}', [
            'middleware' => 'auth',
            'as'=>'void_coupon_redeem_transaction',
            'uses'=>'CouponController@void_coupon_redeem_transaction'
        ]);
        $router->get('pos/coupon/transaction/detail/{coupon_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_coupon_transaction',
            'uses' => 'CouponController@retrieve_coupon_transaction'
        ]);
        $router->get('coupon/void-detail/{coupon_trx_void_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_coupon_transaction_void',
            'uses' => 'CouponController@retrieve_coupon_transaction_void'
        ]);
        $router->get('pos/coupon-redeem/transaction/detail/{coupon_trx_redeem_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_coupon_redeem_transaction',
            'uses' => 'CouponController@retrieve_coupon_redeem_transaction'
        ]);
        $router->get('coupon-redeem/void-detail/{coupon_trx_void_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_coupon_redeem_transaction_void',
            'uses' => 'CouponController@retrieve_coupon_redeem_transaction_void'
        ]);
        $router->get('pos/coupon-agent-redeem/transaction/list', [
            'middleware' => 'auth',
            'as' => 'retrieve_coupon_redeem_by_agent_code',
            'uses' => 'CouponController@retrieve_coupon_redeem_by_agent_code'
        ]);
        $router->post('pos/coupon-agent-redeem-transaction', [
            'middleware' => 'auth',
            'as' => 'create_pos_sales_trx_head_coupon',
            'uses' => 'CouponController@create_pos_sales_trx_head_coupon'
        ]);
        $router->post('coupon-user/{coupon_user_id}', [
            'middleware' => 'auth',
            'as'         => 'coupon_user_edit',
            'uses'       => 'CouponController@coupon_user_edit'
        ]);

        // INVENTORY
        $router->get('inventory/bad-stock', [
            'middleware' => 'auth',
            'as' => 'inv_stock_bad_list',
            'uses' => 'InventoryController@inv_stock_bad_list'
        ]);
        $router->get('inventory/stock', [
            'middleware' => 'auth',
            'as' => 'inv_stock_list',
            'uses' => 'InventoryController@inv_stock_list'
        ]);
        $router->get('inventory/outlet-stock', [
            'middleware' => 'auth',
            'as' => 'inv_stock_per_outlet_list',
            'uses' => 'InventoryController@inv_stock_per_outlet_list'
        ]);
        $router->post('inventory/inventory-in', [
            'middleware' => 'auth',
            'as' => 'inv_in_create',
            'uses' => 'InventoryController@inv_in_create'
        ]);
        $router->post('inventory/inventory-out', [
            'middleware' => 'auth',
            'as' => 'inv_out_create',
            'uses' => 'InventoryController@inv_out_create'
        ]);
        $router->get('inventory/inventory-out/{local_trx_id}', [
            'middleware' => 'auth',
            'as' => 'inv_out_view',
            'uses' => 'InventoryController@inv_out_view'
        ]);
        $router->get('inventory/transfer-in', [
            'middleware' => 'auth',
            'as' => 'inv_transfer_in_list',
            'uses' => 'InventoryController@inv_transfer_in_list'
        ]);
        $router->post('inventory/transfer-in', [
            'middleware' => 'auth',
            'as' => 'inv_transfer_in_create',
            'uses' => 'InventoryController@inv_transfer_in_create'
        ]);
        $router->post('inventory/transfer-out', [
            'middleware' => 'auth',
            'as' => 'inv_transfer_out_create',
            'uses' => 'InventoryController@inv_transfer_out_create'
        ]);
        $router->post('inventory/transfer-out/void/{inv_stock_trf_head_id}', [
            'middleware' => 'auth',
            'as'=>'inv_transfer_out_void',
            'uses'=>'InventoryController@inv_transfer_out_void'
        ]);
        $router->post('inventory/inventory-adjustment', [
            'middleware' => 'auth',
            'as' => 'inv_stock_adj_create',
            'uses' => 'InventoryController@inv_stock_adj_create'
        ]);

        // INV REPORT
        $router->post('report/inv-stock-transaction', [
            'middleware' => 'auth',
            'as'         => 'retrieve_inv_transaction_list',
            'uses'       => 'InventoryController@retrieve_inv_transaction_list'
        ]);

        // OTHERS
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

        // LOYALTY
        $router->post('webhook-no-notif/pos', [
            'middleware' => 'auth',
            'as' => 'no_notif_loyalty_transaction',
            'uses' => 'LoyaltyController@no_notif_loyalty_transaction'
        ]);
        $router->post('loyalty-trx', [
            'middleware' => 'auth',
            'as' => 'offline_loyalty_transaction',
            'uses' => 'LoyaltyController@offline_loyalty_transaction'
        ]);
        $router->post('webhook/pos', [
            'middleware' => 'auth',
            'as' => 'loyalty_transaction',
            'uses' => 'LoyaltyController@loyalty_transaction'
        ]);
        $router->post('loyalty/transaction', [
            'middleware' => 'auth',
            'as' => 'loyalty_transaction',
            'uses' => 'LoyaltyController@loyalty_transaction'
        ]);
        $router->post('wallet-loyalty-transaction', [
            'middleware' => 'auth',
            'as' => 'wallet_loyalty_transaction',
            'uses' => 'LoyaltyController@wallet_loyalty_transaction'
        ]);
        $router->post('save-wallet-loyalty-transaction', [
            'middleware' => 'auth',
            'as' => 'save_wallet_loyalty_transaction',
            'uses' => 'LoyaltyController@save_wallet_loyalty_transaction'
        ]);
        $router->post('loyalty/transaction-upload', [
            'middleware' => 'auth',
            'as' => 'loyalty_upload_transaction',
            'uses' => 'LoyaltyController@loyalty_upload_transaction'
        ]);
        $router->get('loyalty/discount', [
            'middleware' => 'auth',
            'as' => 'get_user_discount_level',
            'uses' => 'LoyaltyController@get_user_discount_level'
        ]);
        $router->get('pos/loyalty/transaction/web-list', [
            'middleware' => 'auth',
            'as' => 'retrieve_loyalty_transactions_for_web',
            'uses' => 'LoyaltyController@retrieve_loyalty_transactions_for_web'
        ]);
        $router->get('pos/loyalty/transaction/detail/{loyalty_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_loyalty_transaction',
            'uses' => 'LoyaltyController@retrieve_loyalty_transaction'
        ]);
        $router->post('pos/loyalty/transaction/void/{loyalty_trx_head_id}', [
            'middleware' => 'auth',
            'as'=>'void_loyalty_transaction',
            'uses'=>'LoyaltyController@void_loyalty_transaction'
        ]);

        // MEMBERSHIP
        $router->get('memberships', [
            'middleware' => 'auth',
            'as' => 'get_business_memberships',
            'uses' => 'MembershipController@get_business_memberships'
        ]);
        $router->post('membership/info', [
            'middleware' => 'auth',
            'as' => 'membership_info',
            'uses' => 'MembershipController@membership_info'
        ]);
        $router->get('member-trx-history', [
            'middleware' => 'auth',
            'as' => 'member_trx_history',
            'uses' => 'MembershipController@member_trx_history'
        ]);
        $router->get('member-item-trx-history', [
            'middleware' => 'auth',
            'as' => 'member_item_trx_history',
            'uses' => 'MembershipController@member_item_trx_history'
        ]);
        $router->post('membership/activation', [
            'middleware' => 'auth',
            'as' => 'membership_activation',
            'uses' => 'MembershipController@membership_activation'
        ]);
        $router->get('pos/membership/transaction/detail/{business_membership_trx_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_membership_transaction',
            'uses' => 'MembershipController@retrieve_membership_transaction'
        ]);
        $router->post('pos/membership/transaction/void/{business_membership_trx_id}', [
            'middleware' => 'auth',
            'as' => 'void_membership_transaction',
            'uses' => 'MembershipController@void_membership_transaction'
        ]);
        $router->post('membership/reference', [
            'middleware' => 'auth',
            'as' => 'refer_customer_id',
            'uses' => 'MembershipController@refer_customer_id'
        ]);
        $router->post('customer-reference', [
            'middleware' => 'auth',
            'as' => 'refer_customer_id',
            'uses' => 'MembershipController@refer_customer_id'
        ]);

        // POS
        $router->get('config', [
            'middleware' => 'auth',
            'as' => 'retrieve_configurations',
            'uses' => 'PosController@retrieve_configurations'
        ]);
        $router->get('pos/config', [
            'middleware' => 'auth',
            'as' => 'retrieve_general_configs',
            'uses' => 'PosController@retrieve_general_configs'
        ]);
        $router->get('pos/item', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_items',
            'uses' => 'PosController@retrieve_pos_items'
        ]);
        $router->get('pos/item-category', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_item_categories',
            'uses' => 'PosController@retrieve_pos_item_categories'
        ]);
        $router->get('pos/discount', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_item_discounts',
            'uses' => 'PosController@retrieve_pos_item_discounts'
        ]);
        $router->get('pos/commission-worker', [
            'middleware' => 'auth',
            'as' => 'retrieve_commission_workers',
            'uses' => 'PosController@retrieve_commission_workers'
        ]);
        $router->get('pos/item-recommendation', [
            'middleware' => 'auth',
            'as' => 'retrieve_item_recommendation',
            'uses' => 'PosController@retrieve_item_recommendation'
        ]);

        //USER
        $router->post('pos/user', [
            'middleware' => 'auth',
            'as' => 'user_info',
            'uses' => 'PosController@user_info'
        ]);
        $router->post('pos/user-wallet', [
            'middleware' => 'auth',
            'as' => 'user_wallet_info',
            'uses' => 'PosController@user_wallet_info'
        ]);
        $router->get('pos/user-search', [
            'middleware' => 'auth',
            'as' => 'user_search',
            'uses' => 'PosController@user_search'
        ]);
        $router->get('pos/member-search', [
            'middleware' => 'auth',
            'as' => 'member_search',
            'uses' => 'PosController@member_search'
        ]);

        //POS TRX
        $router->post('pos/receipt-send', [
            'middleware' => 'auth',
            'as' => 'pos_receipt_send',
            'uses' => 'PosController@pos_receipt_send'
        ]);
        $router->get('pos/receipt-view/{receipt_token}', [
            'as' => 'pos_receipt_view',
            'uses' => 'PosController@pos_receipt_view'
        ]);
        $router->get('pos-trx-history', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_history_list',
            'uses' => 'PosController@pos_sales_trx_history_list'
        ]);
        $router->get('pos-trx-history/{local_trx_id}', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_history_view',
            'uses' => 'PosController@pos_sales_trx_history_view'
        ]);
        $router->get('pos-trx', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_list',
            'uses' => 'PosController@pos_sales_trx_list'
        ]);
        $router->get('pos-trx-detail', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_detail_list',
            'uses' => 'PosController@pos_sales_trx_detail_list'
        ]);
        $router->post('pos-trx', [
            'middleware' => 'authCashier',
            'as' => 'pos_sales_trx',
            'uses' => 'PosController@pos_sales_trx'
        ]);
        $router->put('pos-trx', [
            'middleware' => 'auth',
            'as' => 'pos_sales_trx_edit',
            'uses' => 'PosController@pos_sales_trx_edit'
        ]);
        $router->post('pos-trx/void/{pos_sales_trx_head_id}', [
            'middleware' => 'auth',
            'as'=>'void_pos_sales_trx',
            'uses'=>'PosController@void_pos_sales_trx'
        ]);
        $router->delete('pos-trx/{pos_sales_trx_head_id}', [
            'middleware' => 'auth',
            'as'=>'delete_pending_pos_sales_trx',
            'uses'=>'LoyaltyController@delete_pending_pos_sales_trx'
        ]);

        // POS ITEM
        $router->get('pos-sales-item-summary', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_item_summary',
            'uses' => 'PosController@retrieve_pos_sales_item_summary'
        ]);

        // PRODUCT CONSUMPTION
        $router->get('product-consumption', [
            'middleware' => 'auth',
            'as' => 'product_consumption_list',
            'uses' => 'PosController@product_consumption_list'
        ]);

        // ACCOUNT RECEIVABLE
        $router->get('account-receivable', [
            'middleware' => 'auth',
            'as' => 'account_receivable_list',
            'uses' => 'PosController@account_receivable_list'
        ]);

        // POS SHIFT
        $router->post('pos-shift', [
            'middleware' => 'auth',
            'as' => 'pos_shift',
            'uses' => 'PosController@pos_shift'
        ]);

        // POS SALES TRX COMMISSION
        $router->get('pos-sales-trx-commission-by-trx', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_trx_commission_by_trx',
            'uses' => 'PosController@retrieve_pos_sales_trx_commission_by_trx'
        ]);
        $router->get('pos-sales-trx-commission', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_trx_commission',
            'uses' => 'PosController@retrieve_pos_sales_trx_commission'
        ]);
        $router->get('pos-sales-trx-commission-summary', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_sales_trx_commission_summary',
            'uses' => 'PosController@retrieve_pos_sales_trx_commission_summary'
        ]);

        // OMZET RECAPITULATION
        $router->get('omzet-recapitulation', [
            'middleware' => 'auth',
            'as' => 'retrieve_omzet_recapitulation',
            'uses' => 'PosController@retrieve_omzet_recapitulation'
        ]);

        // EXPIRED COUPONS
        $router->get('coupon-expired', [
            'middleware' => 'auth',
            'as' => 'retrieve_expired_coupons',
            'uses' => 'PosController@retrieve_expired_coupons'
        ]);

        // POS TRX ARCHIVE
        $router->post('pos-sales-trx-archive', [
            'middleware' => 'auth',
            'as' => 'create_archived_trx',
            'uses' => 'PosController@create_archived_trx'
        ]);
        $router->get('pos-sales-trx-archive', [
            'middleware' => 'auth',
            'as' => 'retrieve_archived_trxs',
            'uses' => 'PosController@retrieve_archived_trxs'
        ]);
        $router->get('pos-sales-trx-archive/{local_trx_id}', [
            'middleware' => 'auth',
            'as' => 'pop_archived_trx',
            'uses' => 'PosController@pop_archived_trx'
        ]);

        // CUSTOMER ACTIVITY
        $router->post('customer-activity', [
            'middleware' => 'auth',
            'as' => 'customer_activity_create',
            'uses' => 'PosController@customer_activity_create'
        ]);
        $router->get('customer-activities', [
            'middleware' => 'auth',
            'as' => 'customer_activities_view',
            'uses' => 'PosController@customer_activities_view'
        ]);
        $router->get('customer-activity', [
            'middleware' => 'auth',
            'as' => 'customer_activity_view',
            'uses' => 'PosController@customer_activity_view'
        ]);
        $router->put('customer-activity', [
            'middleware' => 'auth',
            'as' => 'customer_activity_edit',
            'uses' => 'PosController@customer_activity_edit'
        ]);
        $router->delete('customer-activity', [
            'middleware' => 'auth',
            'as' => 'customer_activity_delete',
            'uses' => 'PosController@customer_activity_delete'
        ]);

        // CUSTOMER APPOINTMENT
        $router->post('appointment', [
            'middleware' => 'auth',
            'as' => 'customer_appointment_create',
            'uses' => 'PosController@customer_appointment_create'
        ]);
        $router->put('appointment', [
            'middleware' => 'auth',
            'as' => 'customer_appointment_edit',
            'uses' => 'PosController@customer_appointment_edit'
        ]);
        $router->get('appointment', [
            'middleware' => 'auth',
            'as' => 'customer_appointments_view',
            'uses' => 'PosController@customer_appointments_view'
        ]);
        $router->get('appointment/{local_appointment_id}', [
            'middleware' => 'auth',
            'as' => 'customer_appointment_view',
            'uses' => 'PosController@customer_appointment_view'
        ]);
        $router->delete('appointment/{local_appointment_id}', [
            'middleware' => 'auth',
            'as' => 'customer_appointment_delete',
            'uses' => 'PosController@customer_appointment_delete'
        ]);

        // SETTLEMENT
        $router->get('pos/settlement', [
            'middleware' => 'auth',
            'as' => 'retrieve_pos_settlements',
            'uses' => 'PosController@retrieve_pos_settlements'
        ]);

        // SCRIPT
        $router->put('update-pos-trx/{pos_sales_trx_head_id}', [
            'as' => 'update_pos_trx',
            'uses' => 'PosController@update_pos_trx'
        ]);
        $router->get('update-pos-sales-trx-head/{pos_sales_trx_head_id}', [
            'as' => 'update_pos_sales_trx_head',
            'uses' => 'PosController@update_pos_sales_trx_head'
        ]);
        $router->get('update-pos-sales-trx-payment/{pos_sales_trx_head_id}', [
            'as' => 'update_pos_sales_trx_payment',
            'uses' => 'PosController@update_pos_sales_trx_payment'
        ]);
        $router->get('update-payments', [
            'as' => 'update_payments',
            'uses' => 'PosController@update_payments'
        ]);
        $router->get('fill-coupon', [
            'as' => 'fill_pos_sales_trx_head_coupon',
            'uses' => 'PosController@fill_pos_sales_trx_head_coupon'
        ]);

        // REWARD

        $router->post('sms-redeem-reward', [
            'middleware' => 'auth',
            'as' => 'sms_redeem_rewards',
            'uses' => 'RewardController@sms_redeem_rewards'
        ]);
        $router->post('sms-redeem-reward-resend', [
            'middleware' => 'auth',
            'as' => 'resend_sms_redeem_reward',
            'uses' => 'RewardController@resend_sms_redeem_reward'
        ]);
        $router->post('validate-sms-redeem-reward', [
            'middleware' => 'auth',
            'as' => 'validate_sms_redeem_reward',
            'uses' => 'RewardController@validate_sms_redeem_reward'
        ]);
        $router->post('save-sms-redeem-reward', [
            'middleware' => 'auth',
            'as' => 'save_sms_redeem_reward',
            'uses' => 'RewardController@save_sms_redeem_reward'
        ]);
        $router->get('reward/preview', [
            'middleware' => 'auth',
            'as' => 'redeem_rewards_preview',
            'uses' => 'RewardController@redeem_rewards_preview'
        ]);
        $router->post('reward/redeem', [
            'middleware' => 'auth',
            'as' => 'redeem_rewards',
            'uses' => 'RewardController@redeem_rewards'
        ]);
        $router->post('reward/save-redeem', [
            'middleware' => 'auth',
            'as' => 'save_redeem_rewards',
            'uses' => 'RewardController@save_redeem_rewards'
        ]);

        $router->post('loyalty/migrate', [
            'middleware' => 'auth',
            'as' => 'migrate_loyalty',
            'uses' => 'RewardController@migrate_loyalty'
        ]);
        $router->get('pos/reward/transaction/list', [
            'middleware' => 'auth',
            'as' => 'retrieve_reward_transactions',
            'uses' => 'RewardController@retrieve_reward_transactions'
        ]);
        $router->get('pos/reward/transaction/web-list', [
            'middleware' => 'auth',
            'as' => 'retrieve_reward_transactions_for_web',
            'uses' => 'RewardController@retrieve_reward_transactions_for_web'
        ]);
        $router->get('pos/reward-agent-redeem/transaction/list', [
            'middleware' => 'auth',
            'as' => 'retrieve_reward_redeem_by_agent_code',
            'uses' => 'RewardController@retrieve_reward_redeem_by_agent_code'
        ]);
        $router->post('pos/reward/transaction/void/{reward_trx_head_id}', [
            'middleware' => 'auth',
            'as'=>'void_reward_transaction',
            'uses'=>'RewardController@void_reward_transaction'
        ]);
        $router->get('pos/reward/transaction/detail/{reward_trx_head_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_reward_transaction',
            'uses' => 'RewardController@retrieve_reward_transaction'
        ]);
        $router->get('reward/void-detail/{reward_trx_void_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_reward_transaction_void',
            'uses' => 'RewardController@retrieve_reward_transaction_void'
        ]);

        // REWARD REDEMPTION ITEM
        $router->get('reward-redemption-item', [
            'middleware' => 'auth',
            'as'         => 'reward_redemption_item_list',
            'uses'       => 'RewardController@reward_redemption_item_list'
        ]);

        // USER
        $router->post('user/info', [
            'middleware' => 'auth',
            'as' => 'user_info',
            'uses' => 'UserController@user_info'
        ]);
        $router->post('user/edit', [
            'middleware' => 'auth',
            'as' => 'edit_user_data',
            'uses' => 'UserController@edit_user_data'
        ]);
        $router->post('user/new-nfc-security-code', [
            'middleware' => 'auth',
            'as' => 'new_user_nfc_security_code',
            'uses' => 'UserController@new_user_nfc_security_code'
        ]);
        $router->post('user/nfc-security-code', [
            'middleware' => 'auth',
            'as' => 'edit_user_nfc_security_code',
            'uses' => 'UserController@edit_user_nfc_security_code'
        ]);
        $router->post('user/check-nfc-security-code', [
            'middleware' => 'auth',
            'as' => 'check_user_nfc_security_code',
            'uses' => 'UserController@check_user_nfc_security_code'
        ]);

        // WALLET
        $router->get('wallet/get', [
            'middleware' => 'auth',
            'as' => 'get_business_wallets',
            'uses' => 'WalletController@get_business_wallets'
        ]);
        $router->get('pos/wallet/transaction/list', [
            'middleware' => 'auth',
            'as' => 'retrieve_wallet_transactions',
            'uses' => 'WalletController@retrieve_wallet_transactions'
        ]);
        $router->get('pos/wallet/transaction/web-list', [
            'middleware' => 'auth',
            'as' => 'retrieve_wallet_transactions_for_web',
            'uses' => 'WalletController@retrieve_wallet_transactions_for_web'
        ]);
        $router->get('pos/wallet/transaction/detail/{businessWallet_trx_id}', [
            'middleware' => 'auth',
            'as' => 'retrieve_wallet_transaction',
            'uses' => 'WalletController@retrieve_wallet_transaction'
        ]);
        $router->post('pos/wallet/transaction/void/{businessWallet_trx_id}', [
            'middleware' => 'auth',
            'as'=>'void_wallet_transaction',
            'uses'=>'WalletController@void_wallet_transaction'
        ]);
        $router->post('wallet/top-up', [
            'middleware' => 'auth',
            'as' => 'wallet_top_up',
            'uses' => 'WalletController@wallet_top_up'
        ]);
        $router->post('wallet/update-user-wallet-trx', [
            'middleware' => 'auth',
            'as' => 'update_user_wallet_trx',
            'uses' => 'WalletController@update_user_wallet_trx'
        ]);
        $router->get('wallet/top-up/preview', [
            'middleware' => 'auth',
            'as' => 'wallet_top_up_preview',
            'uses' => 'WalletController@wallet_top_up_preview'
        ]);
    });
});

$router->group(['prefix' => 'cashier'], function () use ($router) {

    // AUTH
    $router->post('pos/auth/sign-in', [
        'uses' => 'AuthController@pos_business_user_signin'
    ]);
    $router->post('pos/auth/sign-in-confirmation', [
        'uses' => 'AuthController@confirm_pos_business_user_signin'
    ]);
    $router->get('pos/auth/sign-out', [
        'as' => 'pos_business_user_signout',
        'uses' => 'AuthController@pos_business_user_signout'
    ]);
    $router->post('pos/auth/sign-out', [
        'as' => 'pos_business_user_signout',
        'uses' => 'AuthController@pos_business_user_signout'
    ]);

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

    $router->get('auth/sign-out', [
        'middleware' => 'auth',
        'as' => 'sign_out',
        'uses' => 'CashierController@sign_out'
    ]);
    $router->get('sign-out', [
        'middleware' => 'auth',
        'as' => 'sign_out',
        'uses' => 'CashierController@sign_out'
    ]);
    $router->post('auth/sign-out', [
        'middleware' => 'auth',
        'as' => 'sign_out',
        'uses' => 'CashierController@sign_out'
    ]);
    $router->post('sign-out', [
        'middleware' => 'auth',
        'as' => 'sign_out',
        'uses' => 'CashierController@sign_out'
    ]);

    // POS
    $router->get('pos/sales/item', [
        'middleware' => 'auth',
        'as' => 'retrieve_pos_transaction_items',
        'uses' => 'CashierController@retrieve_pos_transaction_items'
    ]);
    $router->post('pos/sales/transaction', [
        'middleware' => 'auth',
        'as' => 'pos_sales_transaction',
        'uses' => 'CashierController@pos_sales_transaction'
    ]);
    $router->post('pos/sales/transaction/void', [
        'middleware' => 'auth',
        'as' => 'void_pos_sales_transaction',
        'uses' => 'CashierController@void_pos_sales_transaction'
    ]);
    $router->get('pos/sales/transaction/list', [
        'middleware' => 'auth',
        'as' => 'retrieve_pos_sales_transactions',
        'uses' => 'CashierController@retrieve_pos_sales_transactions'
    ]);
    $router->get('pos/sales/transaction/web-list', [
        'middleware' => 'auth',
        'as' => 'retrieve_pos_sales_transactions_for_web',
        'uses' => 'CashierController@retrieve_pos_sales_transactions_for_web'
    ]);
    $router->get('pos/sales/transaction/detail', [
        'middleware' => 'auth',
        'as' => 'retrieve_pos_sales_transaction',
        'uses' => 'CashierController@retrieve_pos_sales_transaction'
    ]);


    // OTHERS
    $router->get('running-text', [
        'middleware' => 'auth',
        'as'         => 'running_text_list',
        'uses'       => 'CashierController@running_text_list'
    ]);
    $router->get('pos/loyalty/transaction/list', [
        'middleware' => 'auth',
        'as' => 'retrieve_all_transactions',
        'uses' => 'CashierController@retrieve_all_transactions'
    ]);
    $router->get('pos/transaction', [
        'middleware' => 'auth',
        'as' => 'retrieve_all_transactions_for_web',
        'uses' => 'CashierController@retrieve_all_transactions_for_web'
    ]);
    $router->get('help', [
        'middleware' => 'auth',
        'as' => 'get_faq',
        'uses' => 'CashierController@get_faq'
    ]);
    $router->get('help/{business_user_faq_id}', [
        'middleware' => 'auth',
        'as' => 'get_faq_answer',
        'uses' => 'CashierController@get_faq_answer'
    ]);
});