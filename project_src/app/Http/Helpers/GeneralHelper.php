<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessEmailReport;
use App\Models\BusinessOutlet;
use App\Models\BusinessUser;
use App\Models\BusinessUserGroup;
use App\Models\BusinessUserReference;
use App\Models\Outlet;
use App\Models\SubscriptionUserType;
use \App\Models\User;
use App\Models\UserEmail;
use App\Models\UserPhone;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Helper;

class GeneralHelper extends Helper
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // DATETIME
    public static function time_now(){
        return date('H:i:s', time());
    }

    public static function now(){
        return date('Y-m-d H:i:s', time());
    }

    public static function today(){
        return date('Y-m-d', time());
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

    public static function datetime_object_to_date($datetime_object) {
        return date_format($datetime_object,"Y-m-d");
    }

    public static function calculate_datetime_by_duration($start_datetime, $duration, $duration_unit, $is_subtract =
    FALSE) {
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

    //
    public static function hash_password($password){
        return password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);
    }

    public static function generate_random_alphanumeric($length=8){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomNumber;
    }

    public static function generate_random_number($length=8){
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomNumber;
    }

    public static function generate_random_string($length=8, $is_lower=false){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($is_lower){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function get_ellipsis_text($text, $length = 0){
        if (strlen($text) > $length) {
            $temp = '';
            for ($i = 0; $i < strlen($text); $i++) {
                if ($i < $length-2) {
                    $temp .= $text[$i];
                } else {
                    $temp .= '..';
                    break;
                }
            }
            return $temp;
        } else {
            return $text;
        }
    }

    public static function get_complete_parsed_phone_input($phone_string) {
        return '+62' . GeneralHelper::parse_phone_input($phone_string);
    }

    public static function slugify($str) {
        $slug = strtolower($str);
        $slug = preg_replace("/[^\p{L}0-9]/u", '-', $slug);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace("/-+/", '-', $slug);
        $slug = strtolower($slug);

        return ($slug);
    }

    public static function check_base64_string($str) {
        if (!is_array($str)) {
            if (preg_match('#^data:image/\w+;base64,#i', $str) == 1) return TRUE;
            else FALSE;
        }
        else FALSE;
    }

    public static function get_local_phone_number($phone) {
        if (substr($phone, 0, 3) == "+62") {
            return substr($phone, 2);
        } else if (substr($phone, 0, 2) == "62") {
            return substr($phone, 1);
        } else if (substr($phone, 0, 2) == "08") {
            return $phone;
        } else return FALSE;
    }

    public static function is_valid_phone_number($phone_number) {
        $send_sms = 0;
        if (substr($phone_number, 0, 2) == "08") {
            if (strlen($phone_number) < 10) $send_sms = 0;
            else if (strlen($phone_number) > 13) $send_sms = 0;
            else $send_sms = 1;
        } else if(substr($phone_number, 0, 3) == "+62") {
            $phone_number = '0' . substr($phone_number, 3);
            if (strlen($phone_number) < 10) $send_sms = 0;
            else if (strlen($phone_number) > 13) $send_sms = 0;
            else $send_sms = 1;
        } else if(substr($phone_number, 0, 2) == "62") {
            $phone_number = '0' . substr($phone_number, 2);
            if (strlen($phone_number) < 10) $send_sms = 0;
            else if (strlen($phone_number) > 13) $send_sms = 0;
            else $send_sms = 1;
        } else {
            $phone_number = '0' . $phone_number;
            if (strlen($phone_number) < 10) $send_sms = 0;
            else if (strlen($phone_number) > 13) $send_sms = 0;
            else $send_sms = 1;
        }

        return $send_sms;
    }

    public static function send_sms($phone_number, $text) {
        if (GeneralHelper::is_valid_phone_number($phone_number)) {
            SmsHelper::send($phone_number, $text);
        }
    }

    public static function shorten_link($config = array()) {
        # Instantiate the client.
        $client = new Client();

        # Make the call to the client.
        $res = $client->request('POST', 'https://getd.is/shorten', [
            'headers' => [
                'Authorization' => 'X5C4wxTD66WR9jyLkuT6K3usSjXZf2'
            ],
            'form_params' => [
                'long_url' => !empty($config['long_url']) ? $config['long_url'] : '' ,
                'expired_at' => '',
                'short_code' => '',
                'code_length' => !empty($config['code_length']) ? $config['code_length'] : 7
            ]
        ]);

        return $res;
    }

    public static function get_shorten_link($config = array()) {
        $result =  GeneralHelper::shorten_link($config);
        if ($result->getStatusCode() == 200 ) {
            $result = json_decode($result->getBody()->getContents());
            return 'getd.is/' . $result->short_code;
        }
    }

    public static function get_invite_link($invite_code) {
        $config = array(
            'long_url' => 'https://getdiskon.com/invite?c=' . $invite_code,
            'code_length' => 7
        );
        return self::get_shorten_link($config);
    }

    public static function ucwords_enum($enum) {
        return ucwords(
            str_replace(
                '_',
                ' ',
                strtolower($enum)
            )
        );
    }

    public static function convert_data($data_type, $data_value) {
        if (strtolower($data_type) == 'int') {
            return intval($data_value);
        } else if (strtolower($data_type) == 'decimal') {
            return floatval($data_value);
        } else if (strtolower($data_type) == 'string') {
            return strval($data_value);
        } else {
            return null;
        }
    }

    // INPUT
    public static function are_parsed_emails_equal($email1, $email2) {
        return self::parse_email_input($email1) == self::parse_email_input($email2);
    }

    public static function parse_email_input($email) {
        return strtolower(trim($email));
    }

    public static function get_country_code($country_code) {
        return str_replace('+', '', $country_code);
    }

    public static function are_parsed_phones_equal($phone1, $phone2) {
        return self::parse_phone_input($phone1) == self::parse_phone_input($phone2);
    }

    public static function parse_phone_input($phone_string, $country_code_string="+62"){
        // TODO research whether international numbers not starting like its dial code
        $country_code = $country_code_string;
        $country_code = self::get_country_code($country_code);

        $phone = $phone_string;
        $phone = str_replace('+', '', $phone);
        $phone = preg_replace("/[^0-9]/", "", $phone );

        if(substr($phone, 0, 1) == '0'){
            $phone = substr($phone, 1);
        }else{
            if(substr($phone, 0, strlen($country_code)) == $country_code){
                $phone = substr($phone, strlen($country_code));
            }
        }

        return $phone;
    }

    public static function parse_phone_local($phone_string, $country_code_string="+62"){
        $country_code = $country_code_string;
        $country_code = self::get_country_code($country_code);

        $phone = $phone_string;
        $phone = str_replace('+', '', $phone);
        $phone = preg_replace("/[^0-9]/", "", $phone );

        if(substr($phone, 0, strlen($country_code)) == $country_code){
            $phone = substr($phone, strlen($country_code));
        }
        if(substr($phone, 0, 1) != '0'){
            $phone = 0 . $phone;
        }

        return $phone;
    }

    public static function get_phone_full_format($phone_string, $country_code_string="+62"){
        $country_code = $country_code_string;
        $country_code = self::get_country_code($country_code);

        $phone = $phone_string;
        $phone = str_replace('+', '', $phone);
        $phone = preg_replace("/[^0-9]/", "", $phone );

        if(substr($phone, 0, strlen($country_code)) == $country_code){
            $phone = substr($phone, strlen($country_code));
        }

        while (substr($phone, 0, 1) == '0'){
            $phone = substr($phone, 1);
        };

        return $country_code . $phone;
    }

    public static function is_valid_phone($phone_string) {
        $pattern = '/^\+?\d{9,15}$/';
        return preg_match($pattern, $phone_string);
    }

    public static function check_image_input($request, $request_index) {
        if (!empty($request->file($request_index)) || GeneralHelper::check_base64_string($request->input
            ($request_index))) return TRUE;
        else return FALSE;
    }

    public static function set_json_key_value($json_obj, $json_key, $value) {
        if (!empty($json_obj[$json_key])) {
            $json_obj[$json_key] = $value;
        }
        return $json_obj;
    }

    public static function get_json_input($json_obj, $json_key, $onEmpty=NULL) {
        if (empty($json_obj[$json_key])) {
            return $onEmpty;
        } else {
            return $json_obj[$json_key];
        }
    }

    public static function remove_json_key($json_obj, $json_key) {
        if (!empty($json_obj[$json_key])) {
            unset($json_obj[$json_key]);
        }
        return $json_obj;
    }

    public static function if_empty($var, $substitution='') {
        if (empty($var)) {
            return $substitution;
        } else {
            return $var;
        }
    }

    public static function if_not_empty($var, $substitution='') {
        if (!empty($var)) {
            return $substitution;
        } else {
            return $var;
        }
    }

    public static function if_empty_zero_decimal($var) {
        return self::if_empty($var, 0.00);
    }

    public static function if_empty_array($array, $index, $substitution='') {
        if (empty($array[$index])) {
            return $substitution;
        } else {
            return $array[$index];
        }
    }

    // BUSINESS

    public static function generate_webhook_key() {
        $webhook_key = password_hash(self::generate_random_string(20), PASSWORD_BCRYPT, ["cost" => 8]);
        while(Business::where('webhook_key', $webhook_key)->count() > 0)
        {
            $webhook_key = password_hash(self::generate_random_string(20), PASSWORD_BCRYPT, ["cost" => 8]);
        }
        return $webhook_key;
    }

    // BUSINESS USER

    public static function send_verification($business_user_id, $business_id) {

        $business = Business::find($business_id);

        if (empty($business)) {
            return response()->json((["error" => "Brand doesn't exist."]),400);
        }

        $business_user_destination = BusinessUser::where([
            ['business_id', $business_id],
            ['business_user_id', $business_user_id]
        ])->first();

        $subscription_user_type_id = $business_user_destination->subscription_user_type_id;
        $subscription_user_type = SubscriptionUserType::find($subscription_user_type_id);

        if (empty($subscription_user_type)) {
            // Subscription not found in database
            return response()->json(['error' => 'The account doesn\'t have any active subscription.'], 401);
        }

        if (empty($business_user_destination)) {
            return response()->json(ErrorResponseHelper::error_response('SBOF0005'), 400);
        } else if($business_user_destination->is_verified == 1) {
            return response()->json((["error" => "User sudah terverifikasi. Tidak perlu verifikasi ulang."]),400);
        } else if($business_user_destination->is_active == 0) {
            return response()->json((["error" => "User account suspended."]),400);
        }

        $verification_code = GeneralHelper::get_verification_code();
        $business_user_destination->verification_code = $verification_code;
        $business_user_destination->verification_code_expired_time = GeneralHelper::calculate_datetime_by_duration(
            GeneralHelper::now(),
            Controller::BUSINESS_USER_VERIFICTION_DURATION,
            Controller::BUSINESS_USER_VERIFICTION_DURATION_UNIT
        );
        $business_user_destination->save();

        $system_name = '';
        if ($subscription_user_type->subscription_user_type_status == "cashier") {
            $link = Controller::CASHIER_URL . 'auth/verify/' . $verification_code;
            $system_name = 'GD Cashier';
        } else if ($subscription_user_type->subscription_user_type_status == "dashboard") {
            $link = Controller::MERCHANT_URL . 'auth/verify/' . $verification_code;
            $system_name = 'GD Business';
        }

        $business_name = $business->business_name;

        $subject = '[' . $business_name . '] Mengaktifkan Akun ' . $system_name . ' Anda' ;
        $html = view('emails/businessUserVerification', [
            'business_user_firstname' => $business_user_destination->business_user_firstname,
            'system_name' => $system_name,
            'business_name' => $business_name,
            'link' => $link
        ])->render();

        $result = MailgunHelper::send(
            MailgunHelper::DEFAULT_SENDER_NAME,
            MailgunHelper::DEFAULT_SENDER_EMAIL,
            $business_user_destination->business_user_firstname." " .$business_user_destination->business_user_lastname,
            $business_user_destination->business_user_email,
            $subject,
            $html
        );

        return response()->json(['message' => MessageHelper::verification_email_sent()], 200);
    }

    public static function get_forgot_password_code() {
        $forgot_password_code = substr(sha1(self::generate_random_string(20)),7,50);
        $business_user = BusinessUser::where('forgot_password_code', $forgot_password_code)->first();
        while(!empty($business_user))
        {
            $forgot_password_code = substr(sha1(self::generate_random_string(20)),7,50);
        }
        return $forgot_password_code;
    }

    public static function get_verification_code(){
        $verification_code = substr(sha1(self::generate_random_string(20)),7,50);
        while(BusinessUser::where('verification_code', $verification_code)->count() > 0)
        {
        $verification_code = substr(sha1(self::generate_random_string(20)),7,50);
        }
        return $verification_code;
    }

    public static function get_business_user_client_key(){
        $client_key = password_hash(self::generate_random_string(20), PASSWORD_BCRYPT, ["cost" => 8]);
        while(BusinessUser::where('client_key', $client_key)->count() > 0)
        {
            $client_key = password_hash(self::generate_random_string(20), PASSWORD_BCRYPT, ["cost" => 8]);
        }
        return $client_key;
    }

    public static function get_business_user_login_token(){
        $login_token = password_hash(self::generate_random_string(20), PASSWORD_BCRYPT, ["cost" => 8]);
        while(BusinessUser::where('login_token', $login_token)->count() > 0)
        {
            $login_token = password_hash(self::generate_random_string(20), PASSWORD_BCRYPT, ["cost" => 8]);
        }
        return $login_token;
    }

    public static function get_business_user_outlet($business_outlet_id = 0) {
        if ($business_outlet_id != 0) {
            $business_outlet = BusinessOutlet::find($business_outlet_id);
            return $business_outlet->outlet_id;
        } else {
            return 0;
        }
    }

    // BUSINESS EMAIL REPORT

    public static function get_confirmation_code(){
        $confirmation_code = substr(sha1(self::generate_random_string(20)),7,50);
        while(BusinessEmailReport::where('confirmation_code', $confirmation_code)->count() > 0) {
            $confirmation_code = substr(sha1(self::generate_random_string(20)),7,50);
        }
        return $confirmation_code;
    }

    public static function send_confirmation($business_user, $business_email_report) {
        $business_user_name = $business_user->business_user_firstname . ' ' . $business_user->business_user_lastname;
        $business_id = $business_email_report->business_id;
        $report_filter = $business_email_report->report_filter;
        $business = Business::find($business_id);

        if (empty($business)) {
            return response()->json((["error" => "Brand doesn't exist."]),400);
        }

        $business_name = $business->business_name;

        if (strpos($report_filter, "bu_") !== FALSE) {
            $report_type = $business_name;
            $report_filter = explode("bu_", $report_filter);
            $business_user_id = $report_filter[1];
            $business_user = BusinessUser::find($business_user_id);
            if (!empty($business_user)) {
                $report_type .= ' - ' . $business_user->business_user_firstname . ' ' .
                    $business_user->business_user_lastname;
            }
        } else if (strpos($report_filter, "bug_") !== FALSE) {
            $report_type = $business_name;
            $report_filter = explode("bug_", $report_filter);
            $business_user_group_id = $report_filter[1];
            $business_user_group = BusinessUserGroup::find($business_user_group_id);
            if (!empty($business_user_group)) {
                $report_type .= ' - ' . $business_user_group->business_user_group_name;
            }
        } else if (strpos($report_filter, "buo_") !== FALSE) {
            $report_type = $business_name;
            $report_filter = explode("buo_", $report_filter);
            $outlet_id = LoyaltyHelper::get_outlet_id_by_business_outlet_id($report_filter[1]);
            $outlet = Outlet::find($outlet_id);
            if (!empty($outlet)) {
                $report_type .= ' - ' . $outlet->outlet_name;
            }
        } else {
            $report_type = $business_name;
        }

        $link = Controller::MERCHANT_URL . 'auth/activation/' . $business_email_report->confirmation_code;

        $subject = '[' . $business_name . '] Mengaktifkan Email Laporan GD Business' ;
        $html = view('emails/emailReportActivation', [
            'business_name' => $business_name,
            'business_user_name' => $business_user_name,
            'report_type' => $report_type,
            'link' => $link
        ])->render();

        $result = MailgunHelper::send(
            MailgunHelper::DEFAULT_SENDER_NAME,
            MailgunHelper::DEFAULT_SENDER_EMAIL,
            'Mr / Ms',
            $business_email_report->email,
            $subject,
            $html
        );

        return response()->json(['message' => MessageHelper::verification_email_sent()], 200);
    }

    // RUNNING TEXT

    public static function get_running_text($target) {
        $running_text = app('db')->select('
            SELECT 
                rt.running_text_id,
                rt.text
            FROM running_text rt            
            WHERE 
                rt.target = :target
                AND rt.status = "active"
                AND CONCAT(
                  rt.start_date,
                  " ",
                  rt.start_time
                ) <= NOW()
                AND CONCAT(
                  rt.end_date,
                  " ",
                  rt.end_time
                ) >= NOW()
                AND rt.deleted_at IS NULL
            ORDER BY rt.running_text_id ASC
        ', [
            ':target' => $target
        ]);
        return $running_text;
    }

    // USER

    public static function generate_user_code() {
        do{
            $user_code = 'U' . GeneralHelper::generate_random_alphanumeric(6) ;
            $user = User::where('user_code', $user_code)->first();
        }while (!empty($user));

        return $user_code;
    }

    public static function get_user_client_key(){
        $client_key = password_hash(self::generate_random_string(), PASSWORD_BCRYPT, ["cost" => 8]);
        while(User::where('client_key', $client_key)->count() > 0)
        {
            $client_key = password_hash(self::generate_random_string(), PASSWORD_BCRYPT, ["cost" => 8]);
        }
        return $client_key;
    }

    public static function get_user($client_key=""){
        $user = NULL;

        if(!empty($client_key)){
            $user = User::where('client_key', $client_key)->first();
        }

        return $user;
    }

    public static function get_user_by_general($general_string, $string_type="", $business_id = 0){
        $user = NULL;

        if(empty($string_type)){
            if(empty($user)){
                $user = self::get_user_by_email($general_string);
            }

            if(empty($user)){
                $user = self::get_user_by_phone($general_string);
            }

            if(empty($user)){
                $user = self::get_user_by_qr($general_string);
            }

            if(empty($user)){
                $user = self::get_user_by_reference($general_string, $business_id);
            }
        }else{
            switch ($string_type){
                case "qr": {
                    $user = self::get_user_by_qr($general_string);
                    break;
                }

                case "email": {
                    $user = self::get_user_by_email($general_string);
                    break;
                }

                case "phone": {
                    $user = self::get_user_by_phone($general_string);
                    break;
                }

                case "reference": {
                    $user = self::get_user_by_reference($general_string, $business_id);
                    break;
                }

                default: {
                    break;
                }
            }
        }

        return $user;
    }

    public static function get_user_by_email($email_address){
        $user = NULL;

        if(!empty($email_address)){
            $email_address = strtolower($email_address);
//            $user = User::where('email', $email_address)->first();
//            if(empty($user)){
                $user_email = UserEmail::where('email', $email_address)->first();
                if(!empty($user_email)){
                    $user = User::find($user_email->user_id);
                }
//            }
        }

        return $user;
    }

    public static function get_user_by_phone($phone){
        $user = NULL;

        if(!empty($phone)){
            $phone = GeneralHelper::parse_phone_input($phone);
            $user_phone = UserPhone::where([
                'country_code' => '+62',
                'phone' => $phone
            ])->lockForUpdate()->first();
            if(!empty($user_phone)){
                $user = User::find($user_phone->user_id);
            }
        }

        return $user;
    }

    public static function get_user_by_qr($qr_code){
        $user = NULL;

        if(!empty($qr_code)){
            $user = User::where('user_code', $qr_code)->first();
        }

        return $user;
    }

    public static function get_user_by_reference($reference_code, $business_id){
        $user = NULL;

        if(!empty($reference_code)){
            $business_user_reference = BusinessUserReference::where([
                ['business_id', '=', $business_id],
                ['reference_code', '=', $reference_code]
            ])->first();

            if(!empty($business_user_reference)){
                $user_id = $business_user_reference->user_id;
                $user = User::find($user_id);
            }
        }

        return $user;
    }

    public static function get_user_by_user_code($user_code){
        $user = NULL;

        if(!empty($user_code)){
            $user = User::where([
                ['user_code', '=', $user_code]
            ])->first();
        }

        return $user;
    }

    public static function get_user_name($user) {
        return !empty($user->name) ? $user->name : 'Guest';
    }

    public static function register_user_email($user_id, $email) {
        // Retrieve user by email
        $email = strtolower($email);
        $user_email = UserEmail::where('email', $email)->first();

        // Check if user_email has been created before
        if (empty($user_email)) {
            // Create new user_email instance
            $user_email = new UserEmail;
            $user_email->user_id = $user_id;
            $user_email->email = $email;
            $user_email->invite_code = CodeNumberingHelper::generate_email_invite_code();
            $user_email->is_primary = 1;
            $user_email->save();
        } else {
            $user_email->user_id = $user_id;
            $user_email->save();
        }
    }

    public static function register_user_phone($user_id, $phone) {
        // Retrieve user by phone
        $phone = GeneralHelper::parse_phone_input($phone);
        $user_phone = UserPhone::where('phone', $phone)->first();

        // Check if user_phone has been created before
        if (empty($user_phone)) {
            $user_phone_attributes = [
                'user_id' => $user_id,
                'country_code' => Controller::INDONESIA_COUNTRY_CODE,
                'phone' => $phone,
                'invite_code' => CodeNumberingHelper::generate_phone_invite_code(),
                'is_primary' => 1
            ];
            if (substr($phone, 0, 1) == "0") {
                $user_phone_attributes['phone_local'] = $phone;
            } else {
                $user_phone_attributes['phone_local'] = '0' . $phone;
            }
            //TODO add throw json response & using pessimistic locking
            TransactionHelper::update_userstamp($user_phone_attributes);

            DB::table('user_phone')->insertOrIgnore([
                $user_phone_attributes
            ]);
            // Create new user_phone instance
//            $user_phone = new UserPhone;
//            $user_phone->user_id = $user_id;
//            $user_phone->country_code = Controller::INDONESIA_COUNTRY_CODE;
//            $user_phone->phone = $phone;
//            if (substr($phone, 0, 1) == "0") {
//                $user_phone->phone_local = $phone;
//            } else $user_phone->phone_local = '0' . $phone;
//            $user_phone->invite_code = CodeNumberingHelper::generate_phone_invite_code();
//            $user_phone->is_primary = 1;
//            $user_phone->save();
        } else {
            $user_phone->user_id = $user_id;
            $user_phone->save();
            UserHelper::check_primary_phone($user_id, $user_phone);
        }
    }

    // OTHERS
    public function setData($key, $value) {
        array_walk_recursive($value, function (&$item, $key) {
            $item = null === $item ? '' : $item;
        });
        $this->data[$key] = $value;
        return $this->data;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName() {
        // TODO: Implement getName() method.
        return "GeneralHelper";
    }
}
