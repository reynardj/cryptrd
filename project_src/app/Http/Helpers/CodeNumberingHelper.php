<?php

namespace App\Http\Helpers;

use App\Models\Business;
use App\Models\BusinessMembershipTrx;
use App\Models\BusinessReportUser;
use App\Models\BusinessWalletTrx;
use App\Models\CouponTrxExpired;
use App\Models\CouponTrxHead;
use App\Models\CouponTrxVoid;
use App\Models\InvStockTrfHead;
use App\Models\InvStockTrx;
use App\Models\LoyaltyTrxHead;
use App\Models\PosSalesTrxHead;
use App\Models\RewardTrxHead;
use App\Models\RewardTrxVoid;
use App\Models\Scancode;
use App\Models\User;
use App\Models\UserEmail;
use App\Models\UserPhone;
use Ramsey\Uuid\Uuid;

class CodeNumberingHelper
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function generate_phone_verification_code(){
        do{
            $verification_code = GeneralHelper::generate_random_number(6);
            $phone = UserPhone::where('verification_code', $verification_code)->first();
        }while (!empty($phone));

        return $verification_code;
    }

    public static function generate_phone_url_code(){
        do{
            $url_code = GeneralHelper::generate_random_string(40);
            $phone = UserPhone::where('url_code', $url_code)->first();
        }while (!empty($phone));

        return $url_code;
    }

    public static function generate_phone_invite_code(){
        do{
            $invite_code = 'P' . GeneralHelper::generate_random_alphanumeric(6);
            $phone = UserPhone::where('invite_code', $invite_code)->first();
        }while (!empty($phone));

        return $invite_code;
    }

    public static function generate_email_verification_code(){
        do{
            $verification_code = GeneralHelper::generate_random_string(6);
            $email = UserEmail::where('verification_code', $verification_code)->first();
        }while (!empty($email));

        return $verification_code;
    }

    public static function generate_email_url_code(){
        do{
            $url_code = GeneralHelper::generate_random_string(40);
            $email = UserEmail::where('url_code', $url_code)->first();
        }while (!empty($email));

        return $url_code;
    }

    public static function generate_email_invite_code(){
        do{
            $invite_code = 'E' . GeneralHelper::generate_random_alphanumeric(6);
            $email = UserEmail::where('invite_code', $invite_code)->first();
        }while (!empty($email));

        return $invite_code;
    }

    public static function generate_report_user_verification_code(){
        do{
            $verification_code = GeneralHelper::generate_random_number(6);
            $business_report_user = BusinessReportUser::where('verification_code', $verification_code)->first();
        }while (!empty($business_report_user));

        return $verification_code;
    }

    public static function generate_password_verification_code(){
        do{
            $password_verification_code = GeneralHelper::generate_random_string(6);
            $password = User::where('password_verification_code', $password_verification_code)->first();
        }while (!empty($password));

        return $password_verification_code;
    }

    public static function generate_password_url_code(){
        do{
            $password_url_code = GeneralHelper::generate_random_string(40);
            $password = User::where('password_url_code', $password_url_code)->first();
        }while (!empty($password));

        return $password_url_code;
    }

    public static function generate_item_redemption_scancode(){
        do{
            $code = "IR".date('ym').GeneralHelper::generate_random_string(6);
            $scancode = Scancode::where('code', $code)->first();
        }while (!empty($scancode));

        return $code;
    }

    public static function generate_sms_item_redemption_scancode(){
        do{
            $code = "IM".date('ym').GeneralHelper::generate_random_string(6);
            $scancode = Scancode::where('code', $code)->first();
        }while (!empty($scancode));

        return $code;
    }

    public static function generate_direct_item_redemption_trx_id(){
        do{
            $trx_id = "IRTXID".date('ym').GeneralHelper::generate_random_string(6);
            $reward_trx_head = RewardTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($reward_trx_head));

        return $trx_id;
    }

    public static function generate_user_qr(){
        do{
            $code = "U".GeneralHelper::generate_random_string(6);
            $user = User::where('user_code', $code)->first();
        }while (!empty($user));

        return $code;
    }

    public static function number_format_to_integer($number){
        return number_format($number, 0, ',', '.');
    }

    public static function number_to_integer_string($number){
        $var = number_format($number, 0, ',', '.');
        return sprintf('%s',$var);
    }

    public static function generate_coupon_scancode(){
        do{
            $code = "CR".date('ym').GeneralHelper::generate_random_string(6);
            $scancode = Scancode::where('code', $code)->first();
        }while (!empty($scancode));

        return $code;
    }

    // *******
    // OFFICE
    // *******

    public static function generate_business_code() {
        do{
            $business_code = 'BZ' . date('y', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $business = Business::where('business_code', $business_code)->first();
        }while (!empty($business));

        return $business_code;
    }

    // *******
    // CASHIER
    // *******

    public static function generate_loyalty_trx_id($getpos_trx_id, $business_wallet_id = 0) {
        $prefix = 'NP' . 'NW';
        if (empty($getpos_trx_id) && !empty($business_wallet_id)) {
            $prefix = 'NP' . 'WL';
        } else if (!empty($getpos_trx_id) && empty($business_wallet_id)) {
            $prefix = 'PO' . 'NW';
        } else if (!empty($getpos_trx_id) && !empty($business_wallet_id)) {
            $prefix = 'PO' . 'WL';
        }
        do {
            $trx_id = $prefix . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $loyalty_trx = LoyaltyTrxHead::where('trx_id', $trx_id)->first();
        } while (!empty($loyalty_trx));

        return $trx_id;
    }

    public static function get_birthday_loyalty_trx_id($business_wallet_id = 0) {
        $prefix = 'BD' . 'NW';
        if ($business_wallet_id > 0) {
            $prefix = 'NP' . 'WL';
        }
        do{
            $trx_id = $prefix . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $loyalty_trx = LoyaltyTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($loyalty_trx));

        return $trx_id;
    }

    public static function generate_pos_trx_id() {
        $prefix = 'PO' . 'TX';
        do {
            $trx_id = $prefix . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $pos_sales_trx = PosSalesTrxHead::where('trx_id', $trx_id)->first();
        } while (!empty($pos_sales_trx));

        return $trx_id;
    }

    public static function generate_wallet_trx_id() {
        do{
            $trx_id = 'TDTX' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $businessWallet_trx = BusinessWalletTrx::where('trx_id', $trx_id)->first();
        }while (!empty($businessWallet_trx));

        return $trx_id;
    }

    public static function generate_referral_wallet_trx_id() {
        do{
            $trx_id = 'RFTX' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $businessWallet_trx = BusinessWalletTrx::where('trx_id', $trx_id)->first();
        }while (!empty($businessWallet_trx));

        return $trx_id;
    }

    public static function generate_birthday_wallet_trx_id() {
        do{
            $trx_id = 'BDTX' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $businessWallet_trx = BusinessWalletTrx::where('trx_id', $trx_id)->first();
        }while (!empty($businessWallet_trx));

        return $trx_id;
    }

    public static function generate_merchant_coupon_send_trx_id() {
        do{
            $trx_id = 'CSBO' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(3) ;
            $coupon_trx_head = CouponTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($coupon_trx_head));

        return $trx_id;
    }

    public static function generate_cashier_coupon_send_trx_id() {
        do{
            $trx_id = 'CSCH' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(3) ;
            $coupon_trx_head = CouponTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($coupon_trx_head));

        return $trx_id;
    }

    public static function generate_coupon_referral_trx_id() {
        do{
            $trx_id = 'CSRF' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(3) ;
            $coupon_trx_head = CouponTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($coupon_trx_head));

        return $trx_id;
    }

    public static function generate_coupon_redeem_trx_id($code) {
        $trx_id = 'CRTX' . $code ;

        return $trx_id;
    }

    public static function generate_coupon_birthday_trx_id() {
        do{
            $trx_id = 'CSRF' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(3) ;
            $coupon_trx_head = CouponTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($coupon_trx_head));

        return $trx_id;
    }

    public static function generate_reward_trx_id($code) {
        $trx_id = 'IRTX' . $code;

        return $trx_id;
    }

    public static function generate_void_trx_id() {
        do{
            $trx_id = 'VOIDTX' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $loyalty_trx = LoyaltyTrxHead::where('trx_id', $trx_id)->first();
            $pos_trx = PosSalesTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($loyalty_trx) || !empty($pos_trx));

        return $trx_id;
    }

    public static function generate_coupon_void_trx_id() {
        do{
            $trx_id = 'VOIDCR' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $coupon_trx_void = CouponTrxVoid::where('trx_id', $trx_id)->first();
        }while (!empty($coupon_trx_void));

        return $trx_id;
    }

    public static function get_expired_coupon_trx_id() {
        $prefix = 'EXCP';
        do{
            $trx_id = $prefix . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $coupon_trx = CouponTrxExpired::where('trx_id', $trx_id)->first();
        }while (!empty($coupon_trx));

        return $trx_id;
    }

    public static function generate_reward_void_trx_id($reward_trx_type_id = 2) {
        do{
            if ($reward_trx_type_id == 3) {
                $trx_id = 'VOIDMG' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            } else {
                $trx_id = 'VOIDIR' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            }
            $reward_trx_void = RewardTrxVoid::where('trx_id', $trx_id)->first();
        }while (!empty($reward_trx_void));

        return $trx_id;
    }

    public static function generate_membership_void_trx_id() {
        do{
            $trx_id = 'VOIDAC' . date('ym', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $business_membership_trx = BusinessMembershipTrx::where('trx_id', $trx_id)->first();
        }while (!empty($business_membership_trx));

        return $trx_id;
    }

    public static function generate_membership_activation_trx_id() {
        do{
            $trx_id = 'AC' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $businessMembership_trx = BusinessMembershipTrx::where('trx_id', $trx_id)->first();
        }while (!empty($businessMembership_trx));

        return $trx_id;
    }

    public static function generate_migration_trx_id() {
        do{
            $trx_id = 'MG' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $reward_trx_head = RewardTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($reward_trx_head));

        return $trx_id;
    }

    public static function generate_expired_point_trx_id() {
        $prefix = 'EXPN';
        do{
            $trx_id = $prefix . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(6) ;
            $reward_trx = RewardTrxHead::where('trx_id', $trx_id)->first();
        }while (!empty($reward_trx));

        return $trx_id;
    }

    public static function generate_inventory_in_trx_id() {
        do{
            $trx_id = 'INVIN' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $inv_stock_trx = InvStockTrx::where('trx_id', $trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $trx_id;
    }

    public static function generate_inventory_out_trx_id() {
        do{
            $trx_id = 'INVOT' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $inv_stock_trx = InvStockTrx::where('trx_id', $trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $trx_id;
    }

    public static function generate_transfer_head_trx_id() {
        do{
            $trx_id = 'TRFHD' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $inv_stock_trx = InvStockTrfHead::where('trx_id', $trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $trx_id;
    }

    public static function generate_transfer_in_trx_id() {
        do{
            $trx_id = 'TRFIN' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $inv_stock_trx = InvStockTrx::where('trx_id', $trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $trx_id;
    }

    public static function generate_transfer_out_trx_id() {
        do{
            $trx_id = 'TRFOT' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $inv_stock_trx = InvStockTrx::where('trx_id', $trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $trx_id;
    }

    public static function generate_void_transfer_out_trx_id($trx_id) {
        return 'VOID' . $trx_id;
    }

    public static function generate_stock_adj_trx_id() {
        do{
            $trx_id = 'ADJ' . date('ymd', time()) . GeneralHelper::generate_random_alphanumeric(4) ;
            $inv_stock_trx = InvStockTrx::where('trx_id', $trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $trx_id;
    }

    public static function generate_receipt_token() {
        do {
            $receipt_token = GeneralHelper::generate_random_string(60, true);
            $pos_trx = PosSalesTrxHead::where('receipt_token', $receipt_token)->first();
        } while (!empty($pos_trx));

        return $receipt_token;
    }

    public static function generate_sync_token() {
        do {
            $random_string = GeneralHelper::generate_random_string();
            $sync_token = GeneralHelper::hash_password($random_string);
            $pos_trx = PosSalesTrxHead::where('sync_token', $sync_token)->first();
        } while (!empty($pos_trx));

        return $sync_token;
    }

    public static function generate_inv_stock_trx_uuid() {
        do{
            $local_trx_id = Uuid::uuid4()->toString();;
            $inv_stock_trx = InvStockTrx::where('local_trx_id', $local_trx_id)->first();
        }while (!empty($inv_stock_trx));

        return $local_trx_id;
    }
}
