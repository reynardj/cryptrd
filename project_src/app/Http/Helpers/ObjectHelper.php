<?php

namespace App\Http\Helpers;

class ObjectHelper
{
    public static function get_new_object() {
        return new \stdClass();
    }

    public static function is_empty($obj) {
        return empty($obj) || $obj == self::get_new_object();
    }

    public static function is_not_empty($obj) {
        return $obj != self::get_new_object();
    }

    public static function format_to_id_integer_string(&$obj) {
        foreach($obj as $key => $value) {
            if (!is_numeric($obj->{$key})) {
                continue;
            }
            $obj->{$key} = NumberHelper::id_integer_string($value);
        }
    }

    public static function object_key_value_to_text($obj) {
        return implode("\n", array_map(function($k, $v){
            return "$k-$v";
        },
            array_keys((array)$obj), (array)$obj));
    }
}