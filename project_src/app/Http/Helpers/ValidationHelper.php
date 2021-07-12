<?php

namespace App\Http\Helpers;

use App\Models\Country;

class ValidationHelper
{
    public static function is_valid_email($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        }

        return TRUE;
    }

    public static function is_valid_password($password){
        if (strlen($password) < 8) {
            return FALSE;
        }

        return TRUE;
    }

    public static function is_valid_password_confirmation($password, $password_confirmation){
        if ($password !== $password_confirmation) {
            return FALSE;
        }

        return TRUE;
    }

    public static function is_valid_dial_code($dial_code) {
        $dial_code = Country::where('dial_code', $dial_code)->first();
        return !empty($dial_code);
    }
}