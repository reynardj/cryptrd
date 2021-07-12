<?php

namespace App\Http\Helpers;

use App\Jobs\GeneralJob;
use Illuminate\Support\Facades\Config;

class QueueHelper
{
    public static function dispatch_on_warehouse_connection($job) {
        dispatch(
            $job
        )->onConnection(
            Config::get('queue.warehouse')
        );
    }

    public static function dispatch_warehouse_general_job($config, $function) {
        self::dispatch_on_warehouse_connection(new GeneralJob($config, $function));
    }

    public static function dispatch_default_general_job($config, $function, $delay = 0) {
        if (empty($delay)) {
            dispatch(
                new GeneralJob($config, $function)
            );
        } else {
            dispatch(
                new GeneralJob($config, $function)
            )->delay($delay);
        }
    }
}