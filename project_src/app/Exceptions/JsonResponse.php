<?php

namespace App\Exceptions;

use App\Http\Helpers\V2\ErrorResponseHelper;
use Exception;

class JsonResponse extends Exception
{
    private $error_code;

    public function __construct($error_code, $message = null, $code = 0, $previous = null) {
        $this->error_code = $error_code;
        parent::__construct($message, $code, $previous);
    }

    public function get_error_code() {
        return $this->error_code;
    }

    public function render() {
        return response()->json(ErrorResponseHelper::error_response($this->error_code), 400);
    }
}