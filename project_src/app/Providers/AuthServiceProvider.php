<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('Authorization')) {
                if(empty($request->headers->get('Role'))) {
                    if (!empty($request->headers->get('authorization-type'))) {
                        if ($request->headers->get('authorization-type') == "business_user") {
                            return BusinessUser::where([
                                ['client_key', $request->header('Authorization')]
                            ])->first();
                        } else if ($request->headers->get('authorization-type') == "admin") {
                            return Admin::where([
                                ['client_key', $request->header('Authorization')],
                                ['is_active', 1]
                            ])->first();
                        }else if ($request->headers->get('authorization-type') == "webhook") {
                            $business = Business::where([
                                ['webhook_key', $request->header('Authorization')]
                            ])->first();
                            return BusinessUser::where([
                                ['webhook_value', $request->input('webhook_value')],
                                ['business_id', $business->business_id],
                                ['is_active', 1]
                            ])->first();
                        }
                    }

                    return User::where('client_key', $request->header('Authorization'))->first();
                }else{
                    if ($request->headers->get('Role') == "Partner") {
                        return Partner::where([
                            ['api_key', $request->header('Authorization')]
                        ])->first();
                    }
                }
            }
        });
    }
}
