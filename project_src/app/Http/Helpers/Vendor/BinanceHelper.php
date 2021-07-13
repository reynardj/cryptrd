<?php

namespace App\Http\Helpers\Vendor;

use App\Http\Helpers\CurlHelper;
use GuzzleHttp\Client;

class BinanceHelper
{
    /*
     * https://binance-docs.github.io/apidocs/
     *
     */

    const BINANCE_API = 'https://api.binance.com/';
    const BINANCE_API_1 = 'https://api1.binance.com/';
    const BINANCE_API_2 = 'https://api2.binance.com/';
    const BINANCE_API_3 = 'https://api3.binance.com/';

    const MIN_ORDER_VALUE = 10; // USD

    public static function test() {
        $client = new Client();
        $res = CurlHelper::get(self::BINANCE_API_1, []);
        dd($res);
//        $res = $client->request('GET', self::BINANCE_API, [
////            'query' => [
////                'userkey' => 'sitr1k',
////                'passkey' => 'gd123'
////            ],
////            'headers' => [
////                'Accept' => 'application/xml'
////            ]
//        ]);
    }
}