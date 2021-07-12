<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected static function get_userstamp() {
        $user = app('auth')->user();
        $user_type = "";
        $user_id = "";
        $user_name = "";

        if ($user instanceof Admin) {
            $user_type = "admin";
            $user_id = "#" . $user->admin_id;

            if (!empty($user->name)) {
                $user_name = $user->name;
            } else {
                $user_name = "NO NAME";
            }
        }

        if ($user instanceof BusinessUser) {
            $user_type = "business_user";
            $user_id = "#" . $user->business_user_id;

            if (!empty($user->business_user_firstname) && !empty($user->business_user_lastname)) {
                $user_name = $user->business_user_firstname . " " . $user->business_user_lastname;
            } else if (!empty($user->business_user_firstname)) {
                $user_name = $user->business_user_firstname;
            } else if (!empty($user->business_user_lastname)) {
                $user_name = $user->business_user_lastname;
            } else {
                $user_name = "NO NAME";
            }
        }

        if ($user instanceof User) {
            $user_type = "user";
            $user_id = "#" . $user->user_id;
            $user_name = $user->name;
        }

        if (empty($user)) {
            $user_type = "system";
            $user_id = "#1";
            $user_name = "cronjob";
        }

        return $user_type . " " . $user_id . " " . $user_name;
    }
}
