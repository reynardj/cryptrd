<?php

namespace App\Http\Helpers;

class NotificationHelper
{
    // SYSTEM
    public static function notify_admin($message) {
        TelegramHelper::send_message($message);
    }
}