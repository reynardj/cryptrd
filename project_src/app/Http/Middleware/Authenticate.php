<?php

namespace App\Http\Middleware;

use App\Http\Helpers\CashierHelper;
use App\Http\Helpers\ErrorHelper;
use App\Http\Helpers\NotificationHelper;
use App\Http\Helpers\V2\ErrorResponseHelper;
use App\Models\Business;
use App\Models\BusinessUser;
use Exception;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->header('Authorization')) {
            if(!empty($request->headers->get('authorization-type'))){
                if($request->headers->get('authorization-type') == "webhook"){
                    $business = Business::where([
                        ['webhook_key', $request->header('Authorization')]
                    ])->first();
                    if(empty($business)){
                        return response()->json(ErrorResponseHelper::error_response('UFAPI0001'), 400);
                    }
                }

                if($request->headers->get('authorization-type') == "business_user"){
                    $business_user = BusinessUser::withTrashed()->where([
                        ['client_key', $request->header('Authorization')]
                    ])->first();

                    if (!empty($business_user)) {

                        if ($business_user->is_active != 1) {
                            $return = ErrorResponseHelper::error_response('MCLGN0005');
                        } else if (!empty($business_user->deleted_at)) {
                            $return = ErrorResponseHelper::error_response('MCLGN0009');
                        } else if ($business_user->login_token != $request->header('APP-Token')) {
                            $return = ErrorResponseHelper::error_response('MCLGN0008');
                        }

                        if ($business_user->is_active != 1 || !empty($business_user->deleted_at) || $business_user->login_token != $request->header('APP-Token')) {
                            $business_id = $business_user->business_id;

                            app('db')->beginTransaction();
                            try {

                                $return = CashierHelper::settle_all_transactions($business_id, $business_user, $return);

                            } catch (Exception $exception) {
                                app('db')->rollback();
                                ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
                                return response()->json(ErrorResponseHelper::error_response('MCAPI0002'), 400);
                            }
                            app('db')->commit();
                            return response()->json($return, 401);
                        }
                    } else {
                        app('db')->beginTransaction();
                        try {
                            ErrorHelper::general_log(
                                json_encode($request->headers->all())
                            );
                        } catch (Exception $exception) {
                            app('db')->rollback();
                            ErrorHelper::log($request, 'MCAPI0002', $exception->getMessage());
                            return response()->json(ErrorResponseHelper::error_response('MCAPI0002'), 400);
                        }
                        app('db')->commit();
                    }
                }
            }
        }

        if ($this->auth->guard($guard)->guest()) {
            return response()->json(['error' => 'You are unauthorized, please login before proceed further.'], 401);
        }

        return $next($request);
    }
}
