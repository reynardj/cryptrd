<?php

namespace App\Http\Helpers;

use App\Models\ErrorRef;
use stdClass;

class ErrorResponseHelper
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function error_response($error_code, $custom_description=""){
        $error_response = new stdClass;

        $error_ref = ErrorRef::where('error_code', $error_code)->first();
        if(!empty($error_ref)){
            $error_response->code = $error_ref->error_code;
            $error_response->message = $error_ref->message;
            if(!empty($custom_description)){
                $error_response->description = $custom_description;
            }else{
                $error_response->description = $error_ref->description;
            }
            $error_response->link = $error_ref->link;
        }

        $return['error'] = $error_response;
        return $return;
    }
}
