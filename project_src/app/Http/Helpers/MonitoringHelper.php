<?php

namespace App\Http\Helpers;

class MonitoringHelper
{
    private static function count_alert($alert_code, $function) {
        $function = function() use($alert_code, $function) {
            $records = call_user_func($function);
            NotificationHelper::notify_admin($alert_code . count($records) . ' - Ok');
        };
        TransactionHelper::implement_alert_try_catch($function, $alert_code);
    }

    private static function execute_scripts($scripts) {
        foreach ($scripts as $alert_code => $function) {
            self::count_alert($alert_code, $function);
        }
    }

    public static function check_point() {

        $check_point_scripts = array(
            'False rtm end_date - ' => 'App\Http\Helpers\RewardHelper::get_false_rtm_end_date',
            'Credit < Debit - ' => 'App\Http\Helpers\RewardHelper::get_credit_greater_than_debit',
            'rtl - <= CURRENT DATE BUT NOT USED - ' => 'App\Http\Helpers\RewardHelper::get_rtl_outdated_not_used',
            'rtm - <= CURRENT DATE BUT NOT USED - ' => 'App\Http\Helpers\RewardHelper::get_rtm_outdated_not_used',
            'rtr - <= CURRENT DATE BUT NOT USED - ' => 'App\Http\Helpers\RewardHelper::get_rtr_outdated_not_used',
            'rtl - <= CURRENT DATE BUT NOT EXPIRED - ' => 'App\Http\Helpers\RewardHelper::get_rtl_outdated_not_expired',
            'rtm - <= CURRENT DATE BUT NOT EXPIRED - ' => 'App\Http\Helpers\RewardHelper::get_rtm_outdated_not_expired',
            'rtr - <= CURRENT DATE BUT NOT EXPIRED - ' => 'App\Http\Helpers\RewardHelper::get_rtr_outdated_not_expired',
            'rtl - POINT USED BUT AMOUNT != USAGE - ' => 'App\Http\Helpers\RewardHelper::get_rtl_used_usage_mismatched',
            'rtm - POINT USED BUT AMOUNT != USAGE - ' => 'App\Http\Helpers\RewardHelper::get_rtm_used_usage_mismatched',
            'rtr - POINT USED BUT AMOUNT != USAGE - ' => 'App\Http\Helpers\RewardHelper::get_rtr_used_usage_mismatched',
            'Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_empty_rte',
            'Empty rte from Birthday Loyalty - ' => 'App\Http\Helpers\RewardHelper::get_empty_rte_from_birthday_loyalty',
            'Empty rte from Top Up Reward - ' => 'App\Http\Helpers\RewardHelper::get_empty_rte_from_top_up_reward',
            'Empty Top Up Reward - ' => 'App\Http\Helpers\RewardHelper::get_empty_top_up_reward',
            'Empty rte Referenced Not Empty - ' => 'App\Http\Helpers\RewardHelper::get_empty_rte_referenced_not_empty',
            'rtl Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_rtl_empty_rte',
            'rtm Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_rtm_empty_rte',
            'rtr Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_rtr_empty_rte',
            'Empty rtl Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_empty_rtl_empty_rte',
            'Empty rtl Empty rte from Membership Activation - ' => 'App\Http\Helpers\RewardHelper::get_empty_rtl_empty_rte_from_membership_activation',
            'Empty rtl Empty rte from Top Up Wallet - ' => 'App\Http\Helpers\RewardHelper::get_empty_rtl_empty_rte_from_top_up_wallet',
            'Empty rtm Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_empty_rtm_empty_rte',
            'Empty rtr Empty rte - ' => 'App\Http\Helpers\RewardHelper::get_empty_rtr_empty_rte',
            'rte greater than rtl - ' => 'App\Http\Helpers\RewardHelper::get_rte_greater_than_rtl',
            'rte greater than rtm - ' => 'App\Http\Helpers\RewardHelper::get_rte_greater_than_rtm',
            'rte greater than rtr - ' => 'App\Http\Helpers\RewardHelper::get_rte_greater_than_rtr',
            'rtl point_amount = point_used, is_point_used = 0 - ' => 'App\Http\Helpers\RewardHelper::get_rtl_wrong_point_used_flag',
            'rtm point_amount = point_used, is_point_used = 0 - ' => 'App\Http\Helpers\RewardHelper::get_rtm_wrong_point_used_flag',
            'rtr reward_value = point_used, is_point_used = 0 - ' => 'App\Http\Helpers\RewardHelper::get_rtr_wrong_point_used_flag',
        );

        self::execute_scripts($check_point_scripts);
    }

    public static function check_redeem() {
        $check_redeem_scripts = array(
            'redeem_item_using_deleted_pos_item - ' => 'App\Http\Helpers\RewardHelper::get_redeem_item_using_deleted_pos_item',
            'False cth_outlet_same_outlet_coupon_redeem - ' => 'App\Http\Helpers\PosHelper::get_false_cth_outlet_same_outlet_coupon_redeem',
            'Coupon Redeem - ' => 'App\Http\Helpers\PosHelper::get_false_psthc_pstd_item_qty',
            'False psthc_pstd_coupon_item - ' => 'App\Http\Helpers\PosHelper::get_false_psthc_pstd_coupon_item',
            'Redeem Item - ' => 'App\Http\Helpers\PosHelper::get_false_psthr_pstd_item_qty',
            'False psthr_pstd_redeem_item - ' => 'App\Http\Helpers\PosHelper::get_false_psthr_pstd_redeem_item',
        );

        self::execute_scripts($check_redeem_scripts);
    }

    private static function execute_script_without_alert_code($scripts) {
        foreach ($scripts as $alert_code => $function) {
            $function = function() use($alert_code, $function) {
                call_user_func($function);
            };
            TransactionHelper::implement_alert_try_catch($function, $alert_code);
        }
    }

    public static function check_coupon() {
        $check_coupon_scripts = array(
            'False Deleted Coupon - ' => 'App\Http\Helpers\CouponHelper::get_false_deleted_coupon',
        );

        self::execute_scripts($check_coupon_scripts);

        $check_coupon_scripts = array(
            'False Coupon Image - ' => 'App\Http\Helpers\CouponHelper::get_false_coupon_image'
        );

        MonitoringHelper::execute_script_without_alert_code($check_coupon_scripts);
    }

    public static function check_membership() {
        $check_membership_scripts = array(
            'Double Membership - ' => 'App\Http\Helpers\MembershipHelper::check_double_membership_list'
        );

        MonitoringHelper::execute_script_without_alert_code($check_membership_scripts);
    }

    public static function check_loyalty() {
        $check_loyalty_scripts = array(
            'Double Loyalty Trx - ' => 'App\Http\Helpers\LoyaltyHelper::check_double_loyalty_trx'
        );

        self::execute_scripts($check_loyalty_scripts);
    }

    public static function check_commission_config() {
        $check_commission_config_scripts = array(
            'Double commissionWorkerProfile_detail - ' => 'App\Http\Helpers\BusinessCommissionWorkerHelper::get_double_commissionWorkerProfile_detail',
        );

        self::execute_scripts($check_commission_config_scripts);
    }

    public static function check_notification() {
        $check_notification_scripts = array(
            'Empty Point Reminder - ' => 'App\Http\Helpers\NotificationHelper::get_empty_point_reminder',
            'Empty Point Notification - ' => 'App\Http\Helpers\NotificationHelper::get_empty_point_notification'
        );

        self::execute_scripts($check_notification_scripts);
    }

    public static function check_inventory() {
        $check_inventory_scripts = array(
            'false pos_item_ingredient - ' => 'App\Http\Helpers\InventoryHelper::get_false_pos_item_ingredient',
            'ist istd mismatched - ' => 'App\Http\Helpers\InventoryHelper::get_ist_trf_detail_mismatched',
            'ist Transfer Out & In Mismatched - ' => 'App\Http\Helpers\InventoryHelper::get_ist_trf_out_in_mismatched',
            'ist Void Mismatched - ' => 'App\Http\Helpers\InventoryHelper::get_ist_void_mismatched',
            'False Void Ingredient - ' => 'App\Http\Helpers\InventoryHelper::get_false_void_ingredient',
            'Empty isth uuid - ' => 'App\Http\Helpers\InventoryHelper::get_empty_isth_local_trx_id',
            'Empty ist uuid - ' => 'App\Http\Helpers\InventoryHelper::get_empty_ist_local_trx_id',
            'inv_stock_mismatched_inv_unit_id  - ' => 'App\Http\Helpers\InventoryHelper::get_inv_stock_mismatched_inv_unit_id'
        );

        self::execute_scripts($check_inventory_scripts);

        $check_inventory_scripts = array(
            'App\Http\Helpers\InventoryHelper::get_false_inv_stock_trx_drv_current_qty'
        );

        foreach ($check_inventory_scripts as $function) {
            call_user_func($function);
        }

        $fix_inventory_scripts = array(
            'inv_stock_trx_drv_current_qty' => 'App\Http\Helpers\InventoryHelper::fix_inv_stock_trx_drv_current_qty'
        );
        foreach ($fix_inventory_scripts as $key => $function) {
            call_user_func($function);
        }

    }

    public static function check_wallet() {
        $check_wallet_scripts = array(
            'Double bwu - ' => 'App\Http\Helpers\WalletHelper::get_double_businessWallet_user',
            'Double bwt- ' => 'App\Http\Helpers\WalletHelper::get_double_pos_businessWallet_trx',
            'Loyalty trx using deleted bwu - ' => 'App\Http\Helpers\WalletHelper::get_loyalty_trx_using_deleted_businessWallet_user',
        );

        self::execute_scripts($check_wallet_scripts);
    }

    public static function check_user() {
        $check_user_scripts = array(
            'Double User Email - ' => 'App\Http\Helpers\UserHelper::get_double_user_emails',
            'Non Primary User Email - ' => 'App\Http\Helpers\UserHelper::get_non_primary_user_emails',
            'Empty Drv Primary Email - ' => 'App\Http\Helpers\UserHelper::get_empty_drv_primary_email',
            'Double User Phone - ' => 'App\Http\Helpers\UserHelper::get_double_user_phones',
            'Non Primary User Phone - ' => 'App\Http\Helpers\UserHelper::get_non_primary_user_phones',
            'Empty Drv Primary Phone - ' => 'App\Http\Helpers\UserHelper::get_empty_drv_primary_phone',
            'Double User Device - ' => 'App\Http\Helpers\UserHelper::get_double_user_devices',
            'Double Reference Code In Business - ' => 'App\Http\Helpers\UserHelper::get_double_reference_code_in_business',
            'Multiple Reference Code In User - ' => 'App\Http\Helpers\UserHelper::get_multiple_reference_code_in_user',
            'Undeleted Brand Follow - ' => 'App\Http\Helpers\NotificationHelper::get_undeleted_brand_follows',
            'empty_user_user_business - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_business',
            'double_user_business- ' => 'App\Http\Helpers\UserHelper::get_double_user_business',
            'empty_user_user_business_last_trx - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_business_last_trx',
            'double_user_business_last_trx - ' => 'App\Http\Helpers\UserHelper::get_double_user_business_last_trx',
            'empty_user_user_device - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_device',
            'empty_user_user_email - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_email',
            'empty_user_user_fb - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_fb',
            'empty_user_user_invite_token - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_invite_token',
            'empty_user_user_location_log - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_location_log',
            'empty_user_user_password_log - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_password_log',
            'empty_user_user_phone - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_phone',
            'empty_user_user_reward - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_reward',
            'empty_user_user_temp_referral_referrer_user_id - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_temp_referral_referrer_user_id',
            'empty_user_user_temp_referral_referred_user_id - ' => 'App\Http\Helpers\UserHelper::get_empty_user_user_temp_referral_referred_user_id',
            'Double User Discount - ' => 'App\Http\Helpers\UserBusinessHelper::get_double_business_user_discount'
        );

        self::execute_scripts($check_user_scripts);
    }

    public static function check_pos() {
        $check_pos_payment_scripts = array(
            'pos_item_double_outlet - ' => 'App\Http\Helpers\PosHelper::get_false_pos_item_double_outlet',
            'pos_item_package_double_outlet - ' => 'App\Http\Helpers\PosHelper::get_false_pos_item_package_double_outlet',
            'package_outlet_in_package_item_outlet - ' => 'App\Http\Helpers\PosHelper::get_false_package_outlet_in_package_item_outlet',
            'False Stock Out Required - ' => 'App\Http\Helpers\PosHelper::get_false_stock_out_required',
            'Empty POS Item Item Nature - ' => 'App\Http\Helpers\PosHelper::get_empty_pos_item_item_nature',
            'pos_item_package_variant_cost - ' => 'App\Http\Helpers\PosHelper::get_false_pos_item_package_variant_cost',
            'Empty Date POS Additional Charge - ' => 'App\Http\Helpers\PosHelper::get_empty_date_pos_additionalCharge'
        );

        self::execute_scripts($check_pos_payment_scripts);
    }

    public static function check_pos_payments() {
        $check_pos_payment_scripts = array(
            'False pstp_mdr_percentage_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstp_mdr_percentage_value',
            'False pstp_cash_in_after_mdr - ' => 'App\Http\Helpers\PosHelper::get_false_pstp_cash_in_after_mdr',
            'False pstp_net_payment - ' => 'App\Http\Helpers\PosHelper::get_false_pstp_net_payment',
            'False pstp_cash_amount_change - ' => 'App\Http\Helpers\PosHelper::get_false_pstp_cash_amount_change',
            'False psth_drv_grand_total_pstp_amount - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_pstp_amount',
            'False psth drv_grand_total_drv_amount_paid - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid',
            'False psth drv_grand_total_drv_amount_paid_rounded - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_rounded',
            'False psth drv_grand_total_drv_amount_paid_ceiled - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_ceiled',
            'False psth drv_grand_total_drv_amount_paid_floored - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_floored',
            'False psth drv_grand_total_drv_amount_paid_cash - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_cash',
            'False psth drv_grand_total_drv_amount_paid_cash_rounded - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_cash_rounded',
            'False psth drv_grand_total_drv_amount_paid_cash_ceiled - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_cash_ceiled',
            'False psth drv_grand_total_drv_amount_paid_cash_floored - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_cash_floored',
            'False psth drv_grand_total_drv_amount_paid_deposit - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_deposit',
            'False psth drv_grand_total_drv_amount_paid_receivable - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_grand_total_drv_amount_paid_receivable',
        );

        self::execute_scripts($check_pos_payment_scripts);
    }

    public static function check_pos_drv_attributes() {
        $check_pos_drv_attributes_scripts = array(
            'concurrent psth request - ' => 'App\Http\Helpers\PosHelper::get_concurrent_psth_request',
            'double_bmt - ' => 'App\Http\Helpers\PosHelper::get_double_bmt',
            'double_pstha - ' => 'App\Http\Helpers\PosHelper::get_double_pstha',
            'mismatched_psth_account_receivable_outlet_id - ' => 'App\Http\Helpers\PosHelper::get_mismatched_psth_account_receivable_outlet_id',
            'mismatched_psth_account_receivable_payment_outlet_id - ' => 'App\Http\Helpers\PosHelper::get_mismatched_psth_account_receivable_payment_outlet_id',
            'False psth drv_area_name - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_area_name',
            'False psth drv_cash_in - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_cash_in',
            'False psth drv_payment_charge - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_payment_charge',
            'False psth drv_mdr_value - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_mdr_value',
            'False psth account_receivable_balance - ' => 'App\Http\Helpers\PosHelper::get_false_psth_account_receivable_balance',
            'False psth drv_variant_cost - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_variant_cost',
            'False psth drv_variant_ingredient_cost - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_variant_ingredient_cost',
            'False psth drv_inv_stock_out_cogs - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_inv_stock_out_cogs',
            'False psth_pstdc_drv_total_commission - ' => 'App\Http\Helpers\PosHelper::get_false_psth_pstdc_drv_total_commission',
            'False psth_pstd_drv_total_commission - ' => 'App\Http\Helpers\PosHelper::get_false_psth_pstd_drv_total_commission',
            'False psth drv_net_value - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_net_value',
            'False psth drv_coupon_discount_value_item - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_coupon_discount_value_item',
            'False psth drv_coupon_discount_value_trx - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_coupon_discount_value_trx',
            'False psth drv_item_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_item_discount_value',
            'False psth drv_trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_trx_discount_value',
            'False psth drv_subtotal_after_discount_item_value - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_subtotal_after_discount_item_value',
            'False psth drv_subtotal_after_discount - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_subtotal_after_discount'
        );

        self::execute_scripts($check_pos_drv_attributes_scripts);
    }

    public static function check_pstd_drv_attributes() {
        $check_pstd_drv_attributes_scripts = array(
            'False pstdc_pos_item_variant_id - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_pos_item_variant_id',
            'double_pstd_package_item - ' => 'App\Http\Helpers\PosHelper::get_double_pstd_package_item',
            'double_pstdm - ' => 'App\Http\Helpers\PosHelper::get_double_pstdm',
            'double_pstdmo_by_pstdm - ' => 'App\Http\Helpers\PosHelper::get_double_pstdmo_by_pstdm',
            'pstdmo_using_deleted_pstdm - ' => 'App\Http\Helpers\PosHelper::get_pstdmo_using_deleted_pstdm',
            'double_pstdii - ' => 'App\Http\Helpers\PosHelper::get_double_pstdii',
            'double_pstdii_ist - ' => 'App\Http\Helpers\PosHelper::get_double_pstdii_ist',
            'double_pii - ' => 'App\Http\Helpers\PosHelper::get_double_pii',
            'double_pstda - ' => 'App\Http\Helpers\PosHelper::get_double_pstda',
            'double_pstd_ist_consumption - ' => 'App\Http\Helpers\PosHelper::get_double_pstd_ist_consumption',
            'False pstd drv_area_name - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_area_name',
            'False pstd variant_cost_percentage_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_variant_cost_percentage_value',
            'False pstd package_variant_cost - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_variant_cost',
            'False pstd gross_total - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_gross_total',
            'False psth_drv_gross_total - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_gross_total',
            'False pstd_non_prorated_package_item_gross_total - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_non_prorated_package_item_gross_total',
            'False pstd_prorated_package_item_gross_total - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_gross_total',
            'False pstd_non_prorated_package_item_drv_package_prorated_gross_total - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_non_prorated_package_item_drv_package_prorated_gross_total',
            'False pstd_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_discount_value',
            'False pstd_non_prorated_package_item_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_non_prorated_package_item_discount_value',
            'False pstd_prorated_package_item_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_discount_value',
            'False pstd_non_prorated_package_item_drv_package_prorated_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_non_prorated_package_item_drv_package_prorated_discount_value',
            'False pstd_drv_subtotal - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_subtotal',
            'False psth_drv_subtotal - ' => 'App\Http\Helpers\PosHelper::get_false_psth_drv_subtotal',
            'False pstd_non_prorated_package_item_drv_package_prorated_subtotal - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_non_prorated_package_item_drv_package_prorated_subtotal',
            'False pstd trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_trx_discount_value',
            'False pstd custom_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_custom_discount_value',
            'False pstd drv_custom_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_custom_discount_value',
            'False pstd drv_trx_custom_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_trx_custom_discount_value',
            'False pstd coupon_pos_link_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_coupon_pos_link_type',
            'False pstd coupon_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_coupon_discount_value',
            'False pstd_prorated_package_item_coupon_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_coupon_discount_value',
            'False pstd drv_coupon_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_coupon_discount_value',
            'False pstd drv_coupon_discount_value_discount_pos_link_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_coupon_discount_value_discount_pos_link_type',
            'False pstd_prorated_package_item_drv_coupon_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_drv_coupon_discount_value',
            'False pstd discount_value_on_coupon_item_discount_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_discount_value_on_coupon_item_discount_type',
            'False pstd_prorated_package_item_discount_value_on_coupon_item_discount_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_discount_value_on_coupon_item_discount_type',
            'False pstd redeem_pos_link_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_redeem_pos_link_type',
            'False pstd redeem_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_redeem_discount_value',
            'False pstd_prorated_package_item_redeem_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_redeem_discount_value',
            'False pstd drv_redeem_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_redeem_discount_value',
            'False pstd drv_redeem_discount_value_discount_pos_link_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_redeem_discount_value_discount_pos_link_type',
            'False pstd_prorated_package_item_drv_redeem_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_drv_redeem_discount_value',
            'False pstd discount_value_on_redeem_item_discount_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_discount_value_on_redeem_item_discount_type',
            'False pstd_prorated_package_item_discount_value_on_redeem_item_discount_type - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_prorated_package_item_discount_value_on_redeem_item_discount_type',
            'False pstd drv_loyalty_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_loyalty_discount_value',
            'False pstd drv_defined_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_defined_discount_value',
            'False pstd drv_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_discount_value',
            'False pstd drv_subtotal_after_discount - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_subtotal_after_discount',
            'False pstd package_item_drv_subtotal_after_discount - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_drv_subtotal_after_discount',
            'False pstd drv_tax_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_tax_value',
            'False pstd package_item_drv_tax_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_drv_tax_value',
            'False pstd drv_service_charge_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_service_charge_value',
            'False pstd package_item_drv_service_charge_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_drv_service_charge_value',
            'False pstd drv_additional_charge_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_additional_charge_value',
            'False pstd package_item_drv_additional_charge_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_drv_additional_charge_value',
            'False pstd drv_total_exclude_tax - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_total_exclude_tax',
            'False pstd package_item_drv_total_exclude_tax - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_drv_total_exclude_tax',
            'False pstd drv_prorated_grand_total - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_prorated_grand_total',
            'False pstd package_item_drv_prorated_grand_total - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_drv_prorated_grand_total',
        );

        self::execute_scripts($check_pstd_drv_attributes_scripts);
    }

    public static function check_commission() {
        $check_commission_scripts = array(
            'Empty item qty - ' => 'App\Http\Helpers\PosHelper::get_empty_item_qty',
            'non_prorated_item_pstd_trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_non_prorated_item_pstd_trx_discount_value',
            'non_prorated_package_item_pstd_trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_non_prorated_package_item_pstd_trx_discount_value',
            'non_prorated_item_pstdc_trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_non_prorated_item_pstdc_trx_discount_value',
            'non_prorated_package_item_pstdc_trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_non_prorated_package_item_pstdc_trx_discount_value',
            'False pstdc discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_discount_value',
            'False pstdc item_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_item_discount_value',
            'False pstdc trx_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_trx_discount_value',
            'False pstdc loyalty_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_loyalty_discount_value',
            'False pstdc coupon_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_coupon_discount_value',
            'False pstdc redeem_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_redeem_discount_value',
            'False pstdc drv_discount_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_drv_discount_value',
            'psth different item qty - ' => 'App\Http\Helpers\PosHelper::get_psth_different_item_qty',
            'pstdc different item qty - ' => 'App\Http\Helpers\PosHelper::get_pstdc_different_item_qty',
            'False pstd_omzet_prorated- ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_omzet_prorated',
            'False pstd_package_item_coupon_selling_price - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_package_item_coupon_selling_price',
            'False pstd_commission_base_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_commission_base_value',
            'False pstd_worker_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_worker_commission',
            'False pstd_worker_total_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_worker_based_total_commission',
            'False pstd_item_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_item_commission',
            'False pstd_item_total_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_item_based_total_commission',
            'False pstd_empty_worker_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_empty_worker_commission',
            'False pstdc_coupon_selling_price - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_coupon_selling_price',
            'False pstdc_commission_base_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_commission_base_value',
            'False pstdc_omzet_prorated - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_drv_omzet_prorated',
            'False pstdc_worker_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_worker_commission',
            'False pstdc_worker_based_total_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_worker_based_total_commission',
            'False pstdc_item_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_item_commission',
            'False pstdc_item_based_total_commission - ' => 'App\Http\Helpers\PosHelper::get_false_pstdc_item_based_total_commission',
            'False pstdsc_coupon_selling_price - ' => 'App\Http\Helpers\PosHelper::get_false_pstdsc_coupon_selling_price',
            'False pstdsc_commission_base_value - ' => 'App\Http\Helpers\PosHelper::get_false_pstdsc_commission_base_value',
            'False pstdsc_omzet_prorated - ' => 'App\Http\Helpers\PosHelper::get_false_pstdsc_drv_omzet_prorated',
            'False pstd_drv_commission_worker - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_commission_worker',
            'False pstd_drv_commission_seller - ' => 'App\Http\Helpers\PosHelper::get_false_pstd_drv_commission_seller',
        );

        self::execute_scripts($check_commission_scripts);
    }

    // BUG
    public static function check_bug() {
        $check_bug_scripts = array(
            'Commission Profile Bug - ' => 'App\Http\Helpers\PosHelper::get_false_commissionWorkerProfileDetail'
        );

        self::execute_scripts($check_bug_scripts);
    }

    // OFFICE
    public static function send_office_admin_alert() {
        $scripts = array(
            'App\Http\Helpers\LoyaltyHelper::send_office_admin_alert',
            'App\Http\Helpers\RewardHelper::send_office_admin_alert',
            'App\Http\Helpers\BusinessHelper::send_office_admin_alert'
        );

        foreach ($scripts as $function) {
            call_user_func_array($function, array());
        }
    }

    // VENDOR
    public static function check_jurnal() {
        $check_jurnal_scripts = array(
            'Not Success Jurnal Log - ' => 'App\Http\Helpers\Vendor\JurnalHelper::check_jurnal_log'
        );

        self::execute_scripts($check_jurnal_scripts);
    }

    public static function check_adsmedia() {
        $check_adsmedia_scripts = array(
            'Adsmedia Balance - ' => 'App\Http\Helpers\Vendor\AdsmediaHelper::check_adsmedia_balance'
        );

        self::execute_script_without_alert_code($check_adsmedia_scripts);
    }

    // INFRASTRUCTURE
    public static function check_slow_queries() {
        $check_slow_queries_scripts = array(
            'OLTP Slow Log - ' => 'App\Http\Helpers\InfrastructureHelper::get_oltp_slow_log_query',
            'Backup Slow Log - ' => 'App\Http\Helpers\InfrastructureHelper::get_backup_slow_log_query',
            'OLAP Slow Log - ' => 'App\Http\Helpers\InfrastructureHelper::get_olap_slow_log_query'
        );

        self::execute_scripts($check_slow_queries_scripts);
    }

    public static function check_db_slaves() {

        $olap_slave_status = InfrastructureHelper::get_olap_slave_status();
        NotificationHelper::notify_admin($olap_slave_status[0]->{'Slave_SQL_Running_State'});

        $getdiskon_slave_status = InfrastructureHelper::get_getdiskon_slave_status();
        NotificationHelper::notify_admin($getdiskon_slave_status[0]->{'Slave_SQL_Running_State'});
    }
}