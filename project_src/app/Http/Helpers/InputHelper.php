<?php

namespace App\Http\Helpers;

class InputHelper
{
    public static function trim_strtolower($string) {
        return strtolower(trim($string));
    }

    public static function if_not_valid_date($string, $substitution) {
        if (!DateTimeHelper::is_valid_date($string)) {
            return $substitution;
        }
        return $string;
    }

    public static function if_empty($var, $substitution='') {
        if (empty($var)) {
            return $substitution;
        } else {
            return $var;
        }
    }

    public static function if_empty_today($data) {
        if (!empty($data)) {
            return $data;
        }
        return DateTimeHelper::today();
    }

    public static function if_obj_property_empty_null($obj, $property) {
        if (property_exists($obj, $property) || isset($obj->{$property})) {
            return $obj->{$property};
        }
        return NULL;
    }

    public static function if_obj_property_empty($obj, $property, $substitution) {
        if (property_exists($obj, $property) || isset($obj->{$property})) {
            return $obj->{$property};
        }
        return $substitution;
    }

    public static function get_user_data_update_config($request, $business_id) {
        return array(
            'is_edit_user' => $request->input('is_edit_user'),
            'user_name' => $request->input('user_name'),
            'user_gender' => $request->input('user_gender'),
            'user_birth_date' => $request->input('user_birth_date'),
            'user_notes' => $request->input('user_notes'),
            'user_email_notification' => $request->input('user_email_notification'),
            'business_id' => $business_id
        );
    }
}