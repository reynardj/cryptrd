<?php

namespace App\Http\Controllers;

use app\Http\Helpers\CryptoSwingBotHelper;
use App\Http\Helpers\ErrorHelper;
use App\Http\Helpers\GeneralHelper;
use App\Http\Helpers\NotificationHelper;
use App\Http\Helpers\TelegramHelper;
use App\Models\Exchange;
use App\Models\Ticker;
use App\Models\TradeSignal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WebhookController
{
    public function rfvs_signal(Request $request) {
        $signals = $request->all();

        app('db')->beginTransaction();
        try {
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
                NotificationHelper::notify_admin('Unknown Trade Signal Ticker: ' . $ticker_name);
            }

            $trade_signal = new TradeSignal;
            $trade_signal->exchange_id = $exchange->exchange_id;
            $trade_signal->ticker_id = $ticker->ticker_id;
            $trade_signal->action = strtoupper(GeneralHelper::if_empty_array($signals, 'action', ''));
            $trade_signal->close = GeneralHelper::if_empty_array($signals, 'close', 0.00);
            $trade_signal->open = GeneralHelper::if_empty_array($signals, 'open', 0.00);
            $trade_signal->high = GeneralHelper::if_empty_array($signals, 'high', 0.00);
            $trade_signal->low = GeneralHelper::if_empty_array($signals, 'low', 0.00);
            $trade_signal->time = GeneralHelper::string_to_datetime(
                GeneralHelper::if_empty_array($signals, 'time', '')
            );
            $trade_signal->timenow = GeneralHelper::string_to_datetime(
                GeneralHelper::if_empty_array($signals, 'timenow', '')
            );
            $trade_signal->volume = GeneralHelper::if_empty_array($signals, 'volume', 0.00);
            $trade_signal->interval = GeneralHelper::if_empty_array($signals, 'interval', '');
            $trade_signal->save();
        } catch (QueryException $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0001', $exception->getMessage());
        } catch (\Exception $exception) {
            app('db')->rollback();
            ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
        }
        app('db')->commit();
    }

    public function telegram_crypto_swing_bot_webhook(Request $request) {
        $body = $request->json()->all();
        if (!isset($body['message'])) {
            exit;
        }
        if (!isset($body['message']['from'])) {
            exit;
        }
        if (!isset($body['message']['text'])) {
            exit;
        }
        if (!isset($body['message']['from']['id'])) {
            exit;
        }
        $telegram_id = $body['message']['from']['id'];
        if (!in_array($telegram_id, config('messenger.telegram.allowed_chat_ids'))) {
            exit;
        }
        $text = $body['message']['text'];

        if ($text == CryptoSwingBotHelper::HELP_COMMAND) {
            TelegramHelper::send_message(
                CryptoSwingBotHelper::get_help_message(),
                $telegram_id
            );
        }

        return response()->json('ok', 200, [], JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
    }
}