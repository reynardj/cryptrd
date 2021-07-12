<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;

class MathHelper
{
    public static function discount_based_on_type($value, $deduction_type, $deduction_value) {
        if ($deduction_type == Controller::PERCENTAGE_DEDUCTION_TYPE) {
            return $value * $deduction_value / 100;
        } else if ($deduction_type == Controller::VALUE_DEDUCTION_TYPE) {
            return $deduction_value;
        }
        return $value;
    }

    public static function calculate_based_on_type($value, $deduction_type, $deduction_value) {
        if ($deduction_type == Controller::PERCENTAGE_DEDUCTION_TYPE) {
            return $value * (100 - $deduction_value) / 100;
        } else if ($deduction_type == Controller::VALUE_DEDUCTION_TYPE) {
            return $value - $deduction_value;
        }
        return $value;
    }

    public static function calculate_included_in_price($value, $percentage, $included = 0) {
        if ($included == 1) {
            return $value * $percentage / (100 + $percentage);
        } else {
            return $value * $percentage / 100;
        }
    }

    public static function subtract_percentage($value, $percentage) {
        return $value - ($value * floatval($percentage) / floatval(100));
    }

    public static function round(&$number, $precision = 2) {
        if (!empty($number)) {
            $number = round($number, $precision);
        } else {
            $number = 0.00;
        }
    }

    public static function get_max_qualified_qty($qty, $max_qty) {
        if ($qty <= $max_qty) {
            return $qty;
        } else {
            return $max_qty;
        }
    }
}