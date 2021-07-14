<?php

namespace app\Http\Helpers;

class CryptoSwingBotHelper
{
    const HELP_COMMAND = '/help';

    public static function get_help_message() {
        return '
            /start: Starts the trader
            /stop: Stops the trader
            /status <trade_id>|[table]: Lists all open trades
                     <trade_id> : Lists one or more specific trades. Separate multiple <trade_id> with a blank space.
                    table : will display trades in a table pending buy orders are marked with an asterisk (*) pending sell orders are marked with a double asterisk (**)
            /trades [limit]: Lists last closed trades (limited to 10 by default)
            /profit: Lists cumulative profit from all finished trades
            /forcesell <trade_id>|all: Instantly sells the given trade or all trades, regardless of profit
            /delete <trade_id>: Instantly delete the given trade in the database
            /performance: Show performance of each finished trade grouped by pair
            /daily <n>: Shows profit or loss per day, over the last n days
            /stats: Shows Wins / losses by Sell reason as well as Avg. holding durationsfor buys and sells.
            /count: Show number of active trades compared to allowed number of trades
            /locks: Show currently locked pairs
            /unlock <pair|id>: Unlock this Pair (or this lock id if it\'s numeric)
            /balance: Show account balance per currency
            /stopbuy: Stops buying, but handles open trades gracefully 
            /reload_config: Reload configuration file 
            /show_config: Show running configuration 
            /logs [limit]: Show latest logs - defaults to 10 
            /whitelist: Show current whitelist 
            /blacklist [pair]: Show current blacklist, or adds one or more pairs to the blacklist. 
            /edge: Shows validated pairs by Edge if it is enabled 
            /help: This help message
            /version: Show version
        ';
    }
}