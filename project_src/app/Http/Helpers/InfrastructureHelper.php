<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Config;

class InfrastructureHelper
{
    public static function set_memory_limit_to_256_mb() {
        ini_set("memory_limit", "256M");
    }

    public static function set_memory_limit_to_one_gb() {
        ini_set("memory_limit", "1152M");
    }

    public static function set_unlimited_max_execution_time() {
        ini_set('max_execution_time', 0);
    }

    public static function get_oltp_slow_log_query() {
        return app('db')->connection(Config::get('database.default'))->select('
            SELECT 
                *
            FROM
                mysql.slow_log
        ');
    }

    public static function get_backup_slow_log_query() {
        return app('db')->connection(Config::get('database.backup'))->select('
            SELECT 
                *
            FROM
                mysql.slow_log
        ');
    }

    public static function get_olap_slow_log_query() {
        return app('db')->connection(Config::get('database.olap'))->select('
            SELECT 
                *
            FROM
                mysql.slow_log
        ');
    }

    public static function get_olap_slave_status() {
        return app('db')->connection(Config::get('database.olap'))->select('
            SHOW SLAVE STATUS;
        ');
    }

    public static function get_getdiskon_slave_status() {
        return app('db')->connection(Config::get('database.getdiskon'))->select('
            SHOW SLAVE STATUS;
        ');
    }
}