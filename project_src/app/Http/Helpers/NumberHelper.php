<?php

namespace App\Http\Helpers;

class NumberHelper
{
    public static function is_not_equal_int($first_value = 0, $second_value = 0) {
        return intval($first_value) != intval($second_value);
    }

    public static function currency_decimal_number_format($number) {
        return number_format($number, 2, '.', ',');
    }

    public static function decimal_number_format($number) {
        return number_format($number, 2, ',', '.');
    }

    public static function no_decimal_number_format($number) {
        return number_format($number, 0);
    }

    public static function integer_number_format($number) {
        return number_format($number, 0, '.', ',');
    }

    // ID
    public static function id_integer_number_format($number){
        return number_format($number, 0, ',', '.');
    }

    public static function id_integer_string($number){
        $var = number_format($number, 0, ',', '.');
        return sprintf('%s',$var);
    }
}