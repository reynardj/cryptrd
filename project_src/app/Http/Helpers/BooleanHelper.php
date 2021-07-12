<?php

namespace App\Http\Helpers;

class BooleanHelper
{
    public static function filter_boolean($value) {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}