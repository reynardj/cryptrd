<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ErrorHelper;
use App\Http\Helpers\GeneralHelper;
use App\Http\Helpers\NotificationHelper;
use App\Models\Exchange;
use App\Models\SmsLog;
use App\Models\Testing;
use App\Models\Ticker;
use App\Models\TradeSignal;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WebhookController
{
    public function adsmedia(Request $request) {
        app('db')->beginTransaction();
        try {
            $input = $request->input('status_respon');
            if (isset($input[0])) {
                $sending_id = $input[0]['sendingid'];
                $sms_log = SmsLog::where('sendingid', $sending_id)->first();
                if (!empty($sms_log)) {
                    $sms_log->status_code = $input[0]['deliverystatus'];
                    $sms_log->status_name = $input[0]['deliverystatustext'];
                    $sms_log->save();
                }
            } else {
                throw new Exception('Adsmedia Webhook Error');
            }
        } catch (QueryException $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0001', $exception->getMessage());
        } catch (\Exception $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
        }
        app('db')->commit();
    }

    public function smsviro(Request $request) {
        app('db')->beginTransaction();
        try {
            $input = $request->input('results');
            if (isset($input[0])) {
                $messageId = $input[0]['messageId'];
                $sms_log = SmsLog::where('sendingid', $messageId)->first();
                if (!empty($sms_log)) {
                    $sms_log->status_code = $input[0]['status']['id'];
                    $sms_log->status_name = $input[0]['status']['name'];
                    $sms_log->save();
                }
            } else {
                throw new Exception('SMS Viro WebhookError');
            }
        } catch (QueryException $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0001', $exception->getMessage());
        } catch (\Exception $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
        }
        app('db')->commit();
    }

    /*
     * https://www.twilio.com/docs/usage/webhooks/sms-webhooks
     *
     * The body of the status delivery message will look similar to the following:
     *
     * SmsSid: SM2xxxxxx
     * SmsStatus: sent
     * Body: McAvoy or Stewart? These timelines can get so confusing.
     * MessageStatus: sent
     * To: +1512zzzyyyy
     * MessageSid: SM2xxxxxx
     * AccountSid: ACxxxxxxx
     * From: +1512xxxyyyy
     * ApiVersion: 2010-04-01
     */
    public function twilio(Request $request) {
        app('db')->beginTransaction();
        try {
            $SmsSid = $request->input('SmsSid');
            $SmsStatus = $request->input('SmsStatus');
            if (isset($SmsSid)) {
                $sms_log = SmsLog::where('sendingid', $SmsSid)->first();
                if (!empty($sms_log)) {
                    $sms_log->status_name = $SmsStatus;
                    $sms_log->save();
                }
            } else {
                throw new Exception('Twilio Webhook Error');
            }
        } catch (QueryException $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0001', $exception->getMessage());
        } catch (\Exception $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
        }
        app('db')->commit();
    }

    public function rfvs_signal(Request $request) {
        $signals = $request->all();

        $exchange_name = GeneralHelper::if_empty_array($signals, 'exchange', '');
        if (empty($exchange_name)) {
            NotificationHelper::notify_admin('Unknown Trade Signal Exchange: ' . $exchange_name);
        }

        $exchange = Exchange::where('exchange_name', $exchange_name)->first();
        if (empty($exchange)) {
            NotificationHelper::notify_admin('Unknown Trade Signal Exchange: ' . $exchange_name);
        }

        $ticker_name = GeneralHelper::if_empty_array($signals, 'ticker', '');
        if (empty($ticker_name)) {
            NotificationHelper::notify_admin('Unknown Trade Signal Ticker: ' . $ticker_name);
        }

        $ticker = Ticker::where('ticker_name', $ticker_name)->first();
        if (empty($ticker)) {
            NotificationHelper::notify_admin('Unknown Trade Signal Exchange: ' . $exchange_name);
        }

        $trade_signal = new TradeSignal;
        $trade_signal->exchange_id = $exchange->exchange_id;
        $trade_signal->ticker_id = $ticker->ticker_id;
        $trade_signal->action = strtoupper(GeneralHelper::if_empty_array($signals, 'action', ''));
        $trade_signal->close = GeneralHelper::if_empty_array($signals, 'close', 0.00);
        $trade_signal->open = GeneralHelper::if_empty_array($signals, 'open', 0.00);
        $trade_signal->high = GeneralHelper::if_empty_array($signals, 'high', 0.00);
        $trade_signal->low = GeneralHelper::if_empty_array($signals, 'low', 0.00);
        $trade_signal->time = GeneralHelper::if_empty_array($signals, 'time', '');
        $trade_signal->timenow = GeneralHelper::if_empty_array($signals, 'timenow', '');
        $trade_signal->volume = GeneralHelper::if_empty_array($signals, 'volume', 0.00);
        $trade_signal->interval = GeneralHelper::if_empty_array($signals, 'interval', '');
        $trade_signal->save();
    }
}