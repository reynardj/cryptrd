<?php

namespace App\Http\Helpers;

use App\Models\ErrorLog;
use Exception;

class ErrorHelper
{
    public static function general_exception_log(Exception $exception) {
        ErrorHelper::general_log(
            $exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getTraceAsString()
        );
    }

    public static function exception_log($request, $error_code, Exception $exception) {
        ErrorHelper::log(
            $request,
            $error_code,
            $exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getTraceAsString()
        );
    }

    public static function log($request, $error_code, $error_message) {

        $error_log = new ErrorLog;
        if (!empty($request)) {
            $error_log->error_data = $request . json_encode($request->all()) . ' ' . $error_message;
        } else {
            $error_log->error_data = $error_message;
        }
        $error_log->error_code = $error_code;
        $error_log->save();
        if (!empty($request)) {
            NotificationHelper::notify_admin($request->path() . ' ' . $error_message);
        } else {
            NotificationHelper::notify_admin($error_message);
        }
    }

    public static function function_log($function_name, $error_code, $data) {

        $error_log = new ErrorLog;
        if (!empty($function_name)) {
            $error_log->error_data = $function_name . json_encode($data);
        } else {
            $error_log->error_data = json_encode($data);
        }
        $error_log->error_code = $error_code;
        $error_log->save();
        if (!empty($function_name)) {
            NotificationHelper::notify_admin($function_name . ' ' . json_encode($data));
        } else {
            NotificationHelper::notify_admin(json_encode($data));
        }
    }

    public static function general_log($error_message) {
        $error_log = new ErrorLog;
        $error_log->error_data = $error_message;
        $error_log->save();
        NotificationHelper::notify_admin($error_message);
    }

    public static function job_log($connection, $job, $data) {
        $error_log = new ErrorLog;
        $error_log->error_data = json_encode($connection) . ' ' . json_encode($job) . ' ' . json_encode($data);
        $error_log->error_code = '';
        $error_log->save();
    }
}