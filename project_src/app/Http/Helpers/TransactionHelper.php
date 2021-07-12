<?php

namespace App\Http\Helpers;

use App\Exceptions\JsonResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionHelper
{
    public static function if_connection_empty_default(&$connection) {
        if (empty($connection)) {
            $connection = config('database.default');
        }
    }

    public static function begin_transaction($connection = NULL) {
        self::if_connection_empty_default($connection);
        DB::connection($connection)->beginTransaction();
        app('db')->connection($connection)->beginTransaction();
    }

    public static function rollback_transaction($connection = NULL) {
        self::if_connection_empty_default($connection);
        DB::connection($connection)->rollBack();
        app('db')->connection($connection)->rollback();
    }

    public static function commit_transaction($connection = NULL) {
        self::if_connection_empty_default($connection);
        DB::connection($connection)->commit();
        app('db')->connection($connection)->commit();
    }

    public static function user_try_catch(callable $run, Request $request) {
        TransactionHelper::begin_transaction();
        try {
            $run();
        } catch (JsonResponse $exception) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0001', $exception->getMessage());
            throw new JsonResponse($exception->get_error_code());
        } catch (QueryException $exception) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'UFAPI0002', $exception->getMessage());
            throw new JsonResponse('UFAPI0002');
        } catch (Exception $exception) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'UFAPI0003', $exception->getMessage());
            throw new JsonResponse('UFAPI0003');
        } catch (\Error $e) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0002', $e->getMessage());
            throw new JsonResponse('MCAPI0002');
        } catch(\Throwable $e) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0002', $e->getMessage());
            throw new JsonResponse('MCAPI0002');
        }
        TransactionHelper::commit_transaction();
    }

    public static function implement_user_try_catch($function, Request $request) {
        call_user_func_array('self::user_try_catch', array($function, $request));
    }

    public static function pos_try_catch(callable $run, Request $request) {
        TransactionHelper::begin_transaction();
        try {
            $run();
        } catch (JsonResponse $exception) {
            TransactionHelper::rollback_transaction();
            throw new JsonResponse($exception->get_error_code());
        } catch (QueryException $exception) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0001', $exception->getMessage());
            throw new JsonResponse('MCAPI0001');
        } catch (Exception $exception) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
            throw new JsonResponse('MCAPI0002');
        } catch (\Error $e) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0002', $e->getMessage());
            throw new JsonResponse('MCAPI0002');
        } catch(\Throwable $e) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::log($request, 'MCAPI0002', $e->getMessage());
            throw new JsonResponse('MCAPI0002');
        }
        TransactionHelper::commit_transaction();
    }

    public static function implement_pos_try_catch($function, Request $request) {
        call_user_func_array('self::pos_try_catch', array($function, $request));
    }

    public static function alert_try_catch(callable $run, $alert_code, $connection = NULL) {
        TransactionHelper::begin_transaction($connection);
        try {
            $run();
        } catch (Exception $exception) {
            TransactionHelper::rollback_transaction($connection);
            NotificationHelper::notify_admin($alert_code . json_encode($exception->getMessage()));
        }
        TransactionHelper::commit_transaction($connection);
    }

    public static function implement_alert_try_catch($function, $alert_code, $connection = NULL) {
        call_user_func_array('self::alert_try_catch', array($function, $alert_code));
    }

    public static function try_catch(callable $run) {
        TransactionHelper::begin_transaction();
        try {
            $run();
        } catch (Exception $exception) {
            TransactionHelper::rollback_transaction();
            ErrorHelper::general_exception_log($exception);
        }
        TransactionHelper::commit_transaction();
    }

    public static function implement_try_catch($function) {
        call_user_func_array('self::try_catch', array($function));
    }
}