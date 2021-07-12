<?php

namespace App\Http\Helpers;

class OperatorHelper
{
    public static function equals_ignore_case_array($text, $texts = array()) {
        if (!empty($texts)) {
            foreach ($texts as $text2) {
                if (strcasecmp(trim($text), trim($text2)) == 0) {
                    return strcasecmp(trim($text), trim($text2)) == 0;
                }
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }
}