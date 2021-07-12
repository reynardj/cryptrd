<?php

namespace App\Http\Helpers;

class NetworkHelper
{
    public static function send_udp($server_ip, $server_port, String $message) {
        if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
            socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
        } else {
            NotificationHelper::notify_admin('can\'t create socketn');
        }
    }

    public static function get_client_ip(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
}