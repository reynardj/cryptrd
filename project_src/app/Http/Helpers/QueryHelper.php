<?php

namespace App\Http\Helpers;

class QueryHelper
{
    public static function build_query($query_string, $query_value) {
        $words = explode(' ', $query_string);
        foreach ($words as $key => $value) {
            if (substr($value, 0, 1) == ':') {
                $param = trim(substr($value, 1));
                $words[$key] = '"' . $query_value[$param] . '"';
            }
        }
        $query_string = implode(' ', $words);
        return $query_string;
    }

    public static function refine_merge_query_bind(&$query_bind, &$query_string, &$query_bind_2) {
        $words = explode(' ', $query_string);
        foreach ($words as $key => $value) {
            if (substr($value, 0, 1) == ':') {
                $param = trim(substr($value, 1));
                $array_bind = ArrayHelper::set_array_bind_key($query_bind, $param, $query_bind_2[$param]);
                unset($query_bind_2[$param]);
                $words[$key] = $array_bind['array_bind_key'];
                $param = trim(substr($array_bind['array_bind_key'], 1));
                $query_bind_2[$param] = $query_bind[$param];
            }
        }
        $query_string = implode(' ', $words);
    }
}