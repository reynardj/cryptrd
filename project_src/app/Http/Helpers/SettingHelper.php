<?php

namespace App\Http\Helpers;

use App\Models\Setting;

class SettingHelper
{
    public static function get_or_create_setting_key($setting_key) {
        $setting = Setting::where('setting_key', $setting_key)->first();
        if (empty($setting)) {
            $setting = new Setting;
            $setting->setting_key = $setting_key;
        }
        return $setting;
    }

    public static function set_setting_value($setting_key, $setting_value) {
        $setting = self::get_or_create_setting_key($setting_key);
        $setting->setting_value = $setting_value;
        $setting->save();
    }

    public static function get_setting_value($setting_key) {
        $setting = self::get_or_create_setting_key($setting_key);
        return $setting->setting_value;
    }
}