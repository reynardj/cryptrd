<?php

namespace App\Http\Helpers;

use App\Exceptions\JsonResponse;

class PresenterHelper
{
    // TODO implement $request->expectsJson()
    public static function return_success_authorization() {
        return self::return_success(["message" => MessageHelper::authorization_success()]);
    }

    public static function return_success_create() {
        return self::return_success(["message" => MessageHelper::record_added()]);
    }

    public static function return_success_update() {
        return self::return_success(["message" => MessageHelper::record_updated()]);
    }

    public static function return_success_delete() {
        return self::return_success(["message" => MessageHelper::record_deleted()]);
    }

    public static function return_success($message) {
        return response()->json($message, 200, [], JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
    }

    public static function throw_json_response_exception($error_code) {
        throw new JsonResponse($error_code);
    }
}