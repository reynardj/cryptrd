<?php

namespace App\Http\Helpers;

use DateTime;

class DateTimeHelper
{
    public static function is_today_first_day_of_month() {
        return DateTimeHelper::today() == DateTimeHelper::first_day_of_this_month();
    }

    public static function is_valid_date($string) {
        return DateTime::createFromFormat('Y-m-d H:i:s', $string) !== FALSE;
    }

    public static function time_now(){
        return date('H:i:s', time());
    }

    public static function now(){
        return date('Y-m-d H:i:s', time());
    }

    public static function today(){
        return date('Y-m-d', time());
    }

    public static function dFY_date_format($date) {
        return date('d F Y', strtotime($date));
    }

    public static function add_first_second($date){
        return $date . ' 00:00:00';
    }

    public static function add_last_second($date){
        return $date . ' 23:59:59';
    }

    public static function string_to_datetime($string) {
        return date('Y-m-d H:i:s', strtotime($string));
    }

    public static function string_to_date($string) {
        return date('Y-m-d', strtotime($string));
    }

    public static function string_to_time($string) {
        return date('H:i:s', strtotime($string));
    }

    public static function string_to_dMy($string) {
        return date('d-M-y', strtotime($string));
    }

    public static function first_day_of_this_week(){
        $date = new \DateTime("monday this week");
        return $date->format('Y-m-d');
    }

    public static function first_day_of_last_week(){
        $date = new \DateTime("monday last week");
        return $date->format('Y-m-d');
    }

    public static function first_day_of_this_month(){
        $date = new \DateTime("first day of this month");
        return $date->format('Y-m-d');
    }

    public static function first_day_of_last_month(){
        $date = new \DateTime("first day of last month");
        return $date->format('Y-m-d');
    }

    public static function last_day_of_last_month() {
        $date = new \DateTime("last day of last month");
        return $date->format('Y-m-d');
    }

    public static function yesterday() {
        $date = new \DateTime("yesterday");
        return $date->format('Y-m-d');
    }

    public static function first_second_of_yesterday() {
        $date = new \DateTime("yesterday");
        return $date->format('Y-m-d') . ' 00:00:00';
    }

    public static function last_second_of_yesterday() {
        $date = new \DateTime("yesterday");
        return $date->format('Y-m-d') . ' 23:59:59';
    }

    public static function last_second_of_last_week() {
        $date = new \DateTime("sunday last week");
        return $date->format('Y-m-d') . ' 23:59:59';
    }

    public static function last_second_of_last_month() {
        $date = new \DateTime("last day of last month");
        return $date->format('Y-m-d') . ' 23:59:59';
    }

    public static function next_two_weeks_from_today() {
        return date('Y-m-d', strtotime('+2 week'));
    }

    public static function next_one_week_from_today() {
        return date('Y-m-d', strtotime('+1 week'));
    }

    public static function last_month_name() {
        $currentMonth = date('F');
        return Date('F Y', strtotime($currentMonth . " last month"));
    }

    public static function string_to_indonesian_format($string) {
        return date('d M Y', strtotime($string));
    }

    public static function is_first_day_of_this_month() {
        return DateTimeHelper::today() == DateTimeHelper::first_day_of_this_month();
    }

    public static function is_first_day_of_this_week() {
        return DateTimeHelper::today() == DateTimeHelper::first_day_of_this_week();
    }

    public static function datetime_object_to_date($datetime_object) {
        return date_format($datetime_object,"Y-m-d");
    }

    public static function calculate_datetime_by_duration($start_datetime, $duration, $duration_unit, $is_subtract = FALSE) {
        if ($is_subtract) {
            $operator = ' -';
        } else {
            $operator = ' +';
        }
        $php_startdate_string = $start_datetime . $operator . $duration . ' ' . $duration_unit;
        $end_date = date("Y-m-d H:i:s", strtotime($php_startdate_string));

        return $end_date;
    }

    public static function calculate_date_by_duration($start_date, $duration, $duration_unit, $is_subtract = FALSE) {
        if ($is_subtract) {
            $operator = ' -';
        } else {
            $operator = ' +';
        }
        $php_startdate_string = $start_date . $operator . $duration . ' ' . $duration_unit;
        $end_date = date("Y-m-d", strtotime($php_startdate_string));

        return $end_date;
    }

    public static function get_days() {
        $days = app('db')->select('
            SELECT 
                d.day_id,
                d.day_name_en,
                d.is_sunday
            FROM day d 
            WHERE 
                d.deleted_at IS NULL 
            ORDER BY d.is_sunday ASC
        ');

        return $days;
    }

    public static function is_expired($date) {
        return strtotime(self::today()) > strtotime($date);
    }

    public static function is_today_birthday($birth_date) {
        return date('m-d', strtotime($birth_date)) == date('m-d', time());
    }

    public static function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}