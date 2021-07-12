<?php

namespace App\Http\Helpers;

class ArrayHelper
{
    public static function set_array_bind_key(&$array_bind, $array_bind_key, $array_bind_value) {
        $temp = $array_bind_key;
        $array_key = $temp;
        $x = 1;
        while (array_key_exists($array_key, $array_bind)) {
            $array_key = $temp . $x;
            $x++;
        }
        if (empty($array_bind[$array_key])) {
            $array_bind[$array_key] = $array_bind_value;
        }
        return array(
            'array_bind_key' => ':' . $array_key,
            'array_bind' => $array_bind
        );
    }

    public static function array_to_where_in_query($array = array()) {
        $query = '(';
        foreach ($array as $key => $row) {
            if ($key == 0) {
                $query .= $row;
            } else {
                $query .= ', ' . $row;
            }
        }
        $query .= ')';
        return $query;
    }

    public static function is_array_containing_null($array) {
        foreach ($array as $key => $row) {
            if (empty($row)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public static function array_json_decode($input) {
        return json_decode($input, TRUE);
    }

    public static function isset_not_empty($array, $index) {
        if (isset($array[$index])) {
            if (!empty($array[$index])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function if_empty_array($array, $index, $substitution='') {
        if (empty($array[$index])) {
            return $substitution;
        } else {
            return $array[$index];
        }
    }

    public static function if_empty_string($array, $index) {
        return self::if_empty_array($array, $index, '');
    }

    public static function if_empty_new_object($array, $index) {
        return self::if_empty_array($array, $index, ObjectHelper::get_new_object());
    }

    public static function usort_end_date_asc(array &$array) {
        usort($array, function ($a, $b) {
            if ($a->end_date == $b->end_date) {
                return strtotime($a->created_at) - strtotime($b->created_at);
            }
            return strtotime($a->end_date) - strtotime($b->end_date);
        });
    }

    public static function set_array(&$array, $index, $value) {
        $array[$index] = $value;
    }

    public static function key_to_value($array = array()) {
        $temp = array();
        foreach ($array as $key => $value) {
            array_push($temp, $key);
        }
        return $temp;
    }

    public static function get_prev_key($key, $array = array()) {
        $keys = array_keys($array);
        $found_index = array_search($key, $keys);
        if ($found_index === false || $found_index === 0)
            return false;
        return $keys[$found_index-1];
    }

    public static function get_prev_value($key, $array = array()) {
        $key = self::get_prev_key($key, $array);
        if (empty($array)) {
            $array;
        }
        return $array[$key];
    }

    public static function get_index_key_of_array($array, $array_key) {
        return array_search(
            $array_key,
            array_keys($array)
        );
    }

    public static function get_index_prev_key_of_array($array, $array_key) {
        return array_search(
            self::get_prev_key($array_key, $array),
            array_keys($array)
        );
    }
}