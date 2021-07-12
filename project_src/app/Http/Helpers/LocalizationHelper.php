<?php

namespace App\Http\Helpers;

class LocalizationHelper
{
    const EN_LOCALE = 'en';
    const ID_LOCALE = 'id';

    public static function localize_number($number, $locale = self::EN_LOCALE) {
        if ($locale == self::ID_LOCALE) {
            return NumberHelper::decimal_number_format($number);
        } else {
            return NumberHelper::currency_decimal_number_format($number);
        }
    }
}