<?php

namespace App\Http\Helpers\Vendor;

use App\Http\Helpers\CurlHelper;
use App\Http\Helpers\NotificationHelper;

class AdsmediaHelper
{
    public static function check_adsmedia_balance() {
        $response = CurlHelper::post_json(
            array(),
            config('sms.adsmedia.otp_balance_api_endpoint_url'),
            array('apikey' => config('sms.adsmedia.apikey'))
        );
        NotificationHelper::notify_admin('Adsmedia Balance ' . json_encode($response));
    }
}