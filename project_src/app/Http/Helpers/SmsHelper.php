<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;
use App\Jobs\AdsmediaSmsJob;
use App\Jobs\SmsLog;
use App\Jobs\SmsViroRegularSmsJob;
use App\Jobs\SmsViroSmsJob;
use App\Jobs\TwilioSmsJob;
use App\Jobs\ZenzivaSmsJob;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Console\Helper\Helper;

class SmsHelper extends Helper
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

    public static function is_valid_sms_broadcast($text) {
        $words = explode(' ', $text);
        $forbidden_words = config('sms.broadcast_forbidden_words');

        if (!empty($words) && !empty($forbidden_words)) {
            foreach ($words as $word) {
                foreach ($forbidden_words as $forbidden_word) {
                    if (stripos($word, $forbidden_word) !== FALSE) {
                        return FALSE;
                    }
                }
            }
        }

        return TRUE;
    }

    public static function send($recipient_phone="", $text=""){

        if (empty($recipient_phone) || empty($text)) {
            return;
        }

        $sms_log = SmsHelper::create_sms_log($recipient_phone, $text);
        Queue::push(new SmsLog($sms_log, $recipient_phone, $text));

        return;
    }

    public static function is_below_sms_limit($user) {
        if ($user->sms_count < Controller::SMS_LIMIT) {
            return TRUE;
        }
        return FALSE;
    }

    public static function create_sms_log($phone_number, $sms_text) {
        $sms_log = new \App\Models\SmsLog;
        $sms_log->phone_number = $phone_number;
        $sms_log->text = $sms_text;
        $sms_log->status_code = '';
        $sms_log->retry_count = 0;
        $sms_log->save();
        return $sms_log;
    }

    private static function is_in_phone_prefix_groups($phone_prefix, $phone_prefixes) {
        if (!empty($phone_prefixes)) {
            foreach ($phone_prefixes as $prefix) {
                if ($phone_prefix == $prefix) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public static function is_xl_phone_number($phone_number) {
        $phone_prefix = substr($phone_number, 0, 3);
        $xl_phone_prefixes = config('sms.phone_prefix.xl');

        return self::is_in_phone_prefix_groups($phone_prefix, $xl_phone_prefixes);
    }

    public static function is_tri_phone_number($phone_number) {
        $phone_prefix = substr($phone_number, 0, 3);
        $tri_phone_prefixes = config('sms.phone_prefix.tri');

        return self::is_in_phone_prefix_groups($phone_prefix, $tri_phone_prefixes);
    }

    public static function is_smartfren_phone_number($phone_number) {
        $phone_prefix = substr($phone_number, 0, 3);
        $smartfren_phone_prefixes = config('sms.phone_prefix.smartfren');

        return self::is_in_phone_prefix_groups($phone_prefix, $smartfren_phone_prefixes);
    }

    public static function send_otp_sms($phone_number, $sms_text) {

        $sms_log = SmsHelper::create_sms_log($phone_number, $sms_text);
        $otp_sms_provider = SettingHelper::get_setting_value(Controller::OTP_SMS_PROVIDER_SETTING_KEY);

        if ($otp_sms_provider == Controller::SMSVIRO_OTP_SMS_PROVIDER) {
            $phone_number = GeneralHelper::get_phone_full_format($phone_number);
            Queue::push(new SmsViroSmsJob($sms_log, $phone_number, $sms_text));
        } else if ($otp_sms_provider == Controller::ADSMEDIA_SMS_PROVIDER) {
            Queue::push(new AdsmediaSmsJob($sms_log, $phone_number, $sms_text));
        } else {
            Queue::push(new ZenzivaSmsJob($sms_log, $phone_number, $sms_text));
        }
    }

    public static function send_redeem_sms($phone_number, $sms_text) {

        $sms_log = SmsHelper::create_sms_log($phone_number, $sms_text);
        $otp_sms_provider = SettingHelper::get_setting_value(Controller::REDEEM_SMS_PROVIDER_SETTING_KEY);

        if (self::is_xl_phone_number($phone_number) || self::is_tri_phone_number($phone_number)) {
            $phone_number = GeneralHelper::get_phone_full_format($phone_number);
            Queue::push(new TwilioSmsJob($sms_log, $phone_number, $sms_text));
        } else if ($otp_sms_provider == Controller::SMSVIRO_OTP_SMS_PROVIDER) {
            $phone_number = GeneralHelper::get_phone_full_format($phone_number);
            if (self::is_valid_sms_broadcast($sms_text)) {
                Queue::push(new SmsViroRegularSmsJob($sms_log, $phone_number, $sms_text));
            } else {
                Queue::push(new SmsViroSmsJob($sms_log, $phone_number, $sms_text));
            }
        } else {
            Queue::push(new ZenzivaSmsJob($sms_log, $phone_number, $sms_text));
        }
    }

    public static function send_invoice_sms($phone_number, $sms_text) {

        $sms_log = SmsHelper::create_sms_log($phone_number, $sms_text);
        $otp_sms_provider = SettingHelper::get_setting_value(Controller::INVOICE_SMS_PROVIDER_SETTING_KEY);

        if ($otp_sms_provider == Controller::SMSVIRO_OTP_SMS_PROVIDER) {
            $phone_number = GeneralHelper::get_phone_full_format($phone_number);
            Queue::push(new SmsViroSmsJob($sms_log, $phone_number, $sms_text));
        } else {
            Queue::push(new ZenzivaSmsJob($sms_log, $phone_number, $sms_text));
        }
    }

    public static function send_sms($user, $phone_number, $sms_text) {
        if (self::is_below_sms_limit($user)) {
            $sms_log = SmsHelper::create_sms_log($phone_number, $sms_text);
            $otp_sms_provider = SettingHelper::get_setting_value(Controller::GENERAL_SMS_PROVIDER_SETTING_KEY);

            if ($otp_sms_provider == Controller::SMSVIRO_OTP_SMS_PROVIDER) {
                $phone_number = GeneralHelper::get_phone_full_format($phone_number);
                Queue::push(new SmsViroSmsJob($sms_log, $phone_number, $sms_text));
            } else {
                Queue::push(new ZenzivaSmsJob($sms_log, $phone_number, $sms_text));
            }

            $user->sms_count = $user->sms_count + 1;
            $user->save();
        }
    }

    public static function maintain_smsviro_sender_id() {
        $smsviro_premium_sample_numbers = config('sms.smsviro_otp.sample_numbers');

        if (empty($smsviro_premium_sample_numbers)) {
            return;
        }

        foreach ($smsviro_premium_sample_numbers as $smsviro_premium_sample_number) {
            $sms_text = '[Get Diskon] Test SMS ' . GeneralHelper::now();
            $sms_log = SmsHelper::create_sms_log($smsviro_premium_sample_number, $sms_text);
            Queue::push(
                new SmsViroSmsJob($sms_log, $smsviro_premium_sample_number, $sms_text)
            );
        }

        $smsviro_regular_sample_numbers = config('sms.smsviro_regular.sample_numbers');

        if (empty($smsviro_regular_sample_numbers)) {
            return;
        }

        foreach ($smsviro_regular_sample_numbers as $smsviro_regular_sample_number) {
            $is_smartfren = self::is_smartfren_phone_number($smsviro_regular_sample_number);
            if ($is_smartfren) {
                $sender_id = '[' . config('sms.smsviro_regular.smartfren_sender_id') . ']';
            } else {
                $sender_id = '[' . config('sms.smsviro_regular.sender_id') . ']';
            }
            $sms_text = $sender_id . ' Test SMS ' . GeneralHelper::now();
            if (self::is_valid_sms_broadcast($sms_text)) {
                $sms_log = SmsHelper::create_sms_log($smsviro_regular_sample_number, $sms_text);
                Queue::push(
                    new SmsViroRegularSmsJob($sms_log, $smsviro_regular_sample_number, $sms_text)
                );
            }
        }
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName() {
        // TODO: Implement getName() method.
        return "SmsHelper";
    }
}
