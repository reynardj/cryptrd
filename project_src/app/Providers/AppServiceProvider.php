<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new \Illuminate\Routing\ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });
        $this->app->bind('\App\Services\Mail\MailServiceInterface', function ($app) {
            return new \App\Services\Mail\SendinblueMailService();
        });

        $this->app->bind('ITK\Core\Decorator\Notification\TelegramNotificationDecoratorInterface', function ($app) {
            return new \ITK\Core\Decorator\Notification\TelegramNotificationDecorator();
        });

        $this->app->bind('ITK\Core\Decorator\Log\OltpErrorLogDecoratorInterface', function ($app) {
            return new \ITK\Core\Decorator\Log\OltpErrorLogDecorator(
                $app['ITK\Core\Domain\Repository\LogRepositoryInterface'],
                $app['ITK\Core\Decorator\Notification\TelegramNotificationDecorator']
            );
        });

        $this->app->bind('ITK\Core\Decorator\Transaction\PosTransactionDecoratorInterface', function ($app) {
            return new \ITK\Core\Decorator\Transaction\PosTransactionDecorator(
                $app['ITK\Core\Decorator\Log\OltpErrorLogDecoratorInterface']
            );
        });
    }

    public function boot() {
        // DB Listener for debugging purpose
//        \DB::listen(function($query) {
//            $sql = $query->sql;
//            $bindings = $query->bindings;
//            $executionTime = $query->time;
//
//            // do something with the above. Log it, stream it via pusher, etc
//        });
    }
}
