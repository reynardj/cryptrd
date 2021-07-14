<?php

namespace App\Http\Helpers;

use App\Models\TelegramBotLog;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class TelegramHelper
{
    public static function send_message($text = '', $chat_id = '') {
        $texts = str_split($text, Config::get('messenger.telegram.max_message_length'));

        if (!empty($texts)) {
            foreach ($texts as $text) {
                $header = array();

                $parameter = array(
                    "chat_id" => empty($chat_id) ? Config::get('messenger.telegram.default_chat_id') : $chat_id ,
                    "text" => $text
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, Config::get('messenger.telegram.send_message_endpoint'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));

                curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
                curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10000);
                curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10000);

                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

                if (App::environment('local')) {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                }

                // Optional, delete this line if your API is open
                // curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

                $response = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
            }
        }
    }

    public static function log($text) {
        $telegram_bot_log = new TelegramBotLog;
        $telegram_bot_log->description = json_encode($text);
        $telegram_bot_log->save();
    }
}