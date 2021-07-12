<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;
use Symfony\Component\Console\Helper\Helper;

class MessageHelper extends Helper
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

    public static function getdiskon_user_not_found(){
        return "User tidak terdaftar di Get Diskon.";
    }

    public static function business_membership_not_found(){
        return "User belum menjadi member.";
    }

    public static function business_membership_already_exist() {
        return "User sudah pernah terdaftar sebagai member.";
    }

    public static function invalid_request() {
        return "Invalid request.";
    }

    public static function user_reference_already_exist() {
        return "Kode referensi sudah pernah dipakai sebelumnya, cobalah kode lainnya.";
    }

    public static function invalid_scancode() {
        return "Kode yang discan tidak valid atau telah kadaluarsa.";
    }

    public static function insufficient_point() {
        return "Poin tidak mencukupi.";
    }

    public static function transaction_success() {
        return "Transaksi telah berhasil dilakukan.";
    }

    public static function transaction_already_exist() {
        return "Transaksi sudah pernah dilakukan.";
    }

    public static function wallet_not_found() {
        return "Wallet user tidak ditemukan.";
    }

    public static function insufficient_wallet() {
        return "Saldo wallet tidak mencukupi.";
    }

    public static function coupon_not_found() {
        return "Kupon tidak ditemukan.";
    }

    public static function transaction_not_found() {
        return "Transaksi tidak ditemukan.";
    }

    public static function transaction_voided($trx_id) {
        return 'Transaksi dengan ID ' . $trx_id . ' telah berhasil dibatalkan (void)';
    }

    public static function record_not_found() {
        return "Data tidak ditemukan.";
    }

    public static function record_added() {
        return "Data berhasil ditambah.";
    }

    public static function authorization_success() {
        return "Authorization berhasil.";
    }

    public static function record_updated() {
        return "Data telah diperbaharui.";
    }

    public static function record_deleted() {
        return "Data telah dihapus.";
    }

    public static function record_duplicated() {
        return "Data duplikat.";
    }

    public static function record_used() {
        return "Data masih dipakai.";
    }

    public static function email_not_unique() {
        return "Email already used.";
    }

    public static function business_not_found() {
        return "Business not found.";
    }

    public static function user_registered() {
        return "Activation email berhasil dikirimkan ke user yang bersangkutan.";
    }

    public static function verification_email_sent() {
        return "Activation email berhasil dikirimkan ke user yang bersangkutan.";
    }

    public static function unlock_successful() {
        return "User berhasil sign out.";
    }

    public static function sign_out() {
        return "Anda berhasil sign out.";
    }

    // SMS
    public static function get_loyalty_transaction_sms($user, $short_brand_name, $points, $invite_code, $trx_amount) {
        //        if (empty($user->password)) {
//            $link = GeneralHelper::get_invite_link($invite_code);
//        } else {
//            $link = Controller::APP_LINK;
//        }
        $link = Controller::APP_LINK;
        $sms_text = '[GET DISKON] Kamu telah berbelanja di ' . $short_brand_name . ' sebesar IDR ' . $trx_amount . '. Segera download dan lakukan registrasi di ' .
            $link;
        if (!empty($points->reward_amount)) {
            $sms_text = '[GET DISKON] Kamu telah berbelanja di ' . $short_brand_name
                . ' dan mendapatkan reward ' . $points->reward_amount . ' Points. '
                . 'Segera download, lakukan registrasi di ' . $link;
        }
        return $sms_text;
    }

    public static function get_membership_activation_sms($user, $business_membership, $short_brand_name, $points,
                                                         $invite_code) {
//        if (empty($user->password)) {
//            $link = GeneralHelper::get_invite_link($invite_code);
//        } else {
//            $link = Controller::APP_LINK;
//        }
        $link = Controller::APP_LINK;
        $membership_name = GeneralHelper::get_ellipsis_text($business_membership->membership_name, 18);
        $sms_text = '[GET DISKON] Kamu telah mengaktifkan ' . $membership_name . ' di ' .
            $short_brand_name . '. '
            .'Kumpulkan reward kamu dengan download dan melakukan registrasi di ' . $link;
        if (!empty($points->reward_amount)) {
            $sms_text = '[GET DISKON] Kamu telah mengaktifkan ' . $membership_name . ' di ' .
                $short_brand_name
                . ' dan mendapatkan reward ' . $points->reward_amount . ' Points.'
                . ' Segera download dan lengkapi data kamu di ' . $link;
        }
        return $sms_text;
    }

    public static function get_migrate_loyalty_sms($user, $old_loyalty_no, $short_brand_name, $points,
                                                   $invite_code) {
        //        if (empty($user->password)) {
//            $link = GeneralHelper::get_invite_link($invite_code);
//        } else {
//            $link = Controller::APP_LINK;
//        }
        $link = Controller::APP_LINK;
        $sms_text = '[GET DISKON] ID member ' . $old_loyalty_no . ' kamu di ' . $short_brand_name . ' telah berhasil dimigrasi ke sistem GET DISKON. Segera download dan lengkapi data kamu di ' .
            $link;
        if (!empty($points->reward_amount)) {
            $sms_text = '[GET DISKON] ID member ' . $old_loyalty_no . ' kamu di ' . $short_brand_name . ' telah dimigrasi'
                . ' dan mendapatkan reward ' . $points->reward_amount . ' Points. '
                . 'Segera download dan lengkapi data kamu di ' . $link;
        }
        return $sms_text;
    }

    public static function get_redeem_reward_sms($item_name, $point, $point_name, $redeem_code) {
        $point = CodeNumberingHelper::number_format_to_integer($point);
        $item_name = GeneralHelper::get_ellipsis_text($item_name, 35);
        $point_name = GeneralHelper::get_ellipsis_text($point_name, 35);
        return '[Get Diskon / GD App] Kamu akan menukarkan ' . $item_name . ' sebesar ' . $point . ' ' . $point_name . '.'
            . ' Tukar dengan: ' . $redeem_code;
    }

    // NOTIFICATION
    public static function coupon_expired_notification($coupon_name) {
        return $coupon_name . ' telah expired';
    }

    public static function point_expired_notification($expiring_amount, $reward_name) {
        return $expiring_amount . ' ' . $reward_name . ' expired ';
    }

    public static function point_expired_reminder($expiring_amount, $reward_name, $end_date, $brand_name) {
        return 'Kamu memiliki ' . $expiring_amount . ' ' . $reward_name . ' yang akan segera expired pada ' . $end_date . '.'
            . ' Segera gunakan point kamu di outlet - outlet ' . $brand_name . ' terdekat.';
    }

    public static function highest_redeem_item_notification($expiring_amount, $reward_name, $dMy_end_date, $highest_redeem_item_name, $link) {
        return '[GET DISKON] ' . $expiring_amount . ' ' . $reward_name . ' kamu akan berakhir pada '
            . $dMy_end_date . '. Ayo cek poin-mu yg sudah bisa ditukar dgn ' . $highest_redeem_item_name . '! Klik: '
            . $link;
    }

    public static function potential_referred_notification_on_registration($reward_value, $reward_name, $membership_name, $min_trx, $end_date = NULL, $deposit_value = 0, $deposit_name = '', $coupon_value = 0) {

        $rewards = '';

        if (!empty($reward_value)) {
            $rewards .= $reward_value . ' ' . $reward_name;
        }

        if (!empty($deposit_value)) {
            $rewards .= GeneralHelper::if_not_empty($rewards, ', ') . $deposit_value . ' ' . $deposit_name;
        }

        if (!empty($coupon_value)) {
            $rewards .= GeneralHelper::if_not_empty($rewards, ', ') . $coupon_value . ' kupon';
        }

        if (!empty($rewards)) {
            if (empty($end_date)) {
                return "Selamat! "
                    . "Kamu memiliki potensi untuk mendapatkan {$rewards} di {$membership_name}."
                    . " Segera lakukan aktivasi member untuk mendapatkan reward.";
            }
            return "Selamat! "
                . "Kamu memiliki potensi untuk mendapatkan {$rewards} di {$membership_name}."
                . " Segera lakukan aktivasi member & transaksi minimal Rp. {$min_trx},- sebelum tanggal {$end_date}.";
        }

        return '';
    }

    public static function referred_notification_on_registration($reward_value, $reward_name, $membership_name, $deposit_value = 0, $deposit_name = '', $coupon_value = 0) {
        $rewards = '';
        if (!empty($reward_value)) {
            $rewards .= $reward_value . ' ' . $reward_name;
        }
        if (!empty($deposit_value)) {
            $rewards .= GeneralHelper::if_not_empty($rewards, ', ') . $deposit_value . ' ' . $deposit_name;
        }
        if (!empty($coupon_value)) {
            $rewards .= GeneralHelper::if_not_empty($rewards, ', ') . $coupon_value . ' kupon';
        }
        if (!empty($rewards)) {
            return "Selamat! {$membership_name} telah diaktifkan dan kamu mendapatkan {$rewards}.";
        }
        return '';
    }

    public static function membership_expired_reminder($membership_name, $end_date, $brand_name) {
        return $membership_name . ' kamu akan segera expired pada ' . $end_date . '.'
            . ' Segera perbaharui membership kamu untuk dapat terus menikmati reward dari ' . $brand_name;
    }

    public static function coupon_expired_reminder($coupon_name, $end_date) {
        return $coupon_name . ' akan expired pada ' . $end_date ;
    }

    public static function birthday_default_notification() {
        return 'Hi member_name selamat ulang tahun.' .
            ' Spesial buat kamu. brand_name akan berikan kamu point_value, coupon_value, deposit_value.' .
            ' Segera gunakan reward kamu di outlet terdekat';
    }

    public static function replace_birthday_member_name($notification_text, $user, $brand_name) {
        return str_replace(
            "member_name",
            empty($user->name) ? 'Customer ' . $brand_name : $user->name ,
            $notification_text
        );
    }

    // TRX
    public static function top_up_wallet_trx($user_name, $top_up_amount) {
        return 'Deposit ' . $user_name . ' telah berhasil ditambahkan sebesar ' . NumberHelper::id_integer_number_format($top_up_amount);
    }

    public static function void_business_membership_trx($business_membership_name) {
        return 'Aktivasi ' . $business_membership_name . ' telah dibatalkan';
    }

    public static function void_pos($brand_name, $outlet_name) {
        return 'Transaksi kamu di ' . $brand_name . ' ' . $outlet_name . ' pada ' . DateTimeHelper::today() . ' dibatalkan';
    }

    // MONITORING
    public static function get_expiring_loyalty_message($rules_name, $business_name, $end_date) {
        return 'Loyalty Rule bernama ' . $rules_name . ' pada bisnis ' . $business_name . ' akan berakhir pada ' . $end_date;;
    }

    public static function get_expiring_rtm_message($point, $reward_name, $user_name, $end_date) {
        return $point . ' ' . $reward_name . ' milik ' . $user_name . ' akan berakhir pada ' . $end_date;
    }

    public static function get_expiring_subscription_messge($subscription_name, $business_name, $end_date) {
        return 'Subscription ' . $subscription_name . ' pada bisnis ' . $business_name . ' akan berakhir pada ' . $end_date;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName() {
        // TODO: Implement getName() method.
        return "MessageHelper";
    }
}
