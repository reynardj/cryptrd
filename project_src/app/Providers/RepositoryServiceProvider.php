<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ITK\Core\Domain\Repository\BusinessUserRepositoryInterface;
use ITK\Core\Domain\Repository\CommissionWorkerProfileRepositoryInterface;
use ITK\Core\Domain\Repository\LogRepositoryInterface;
use ITK\Core\Domain\Repository\PosSalesTrxRepositoryInterface;
use ITK\Core\Persistence\Eloquent\BusinessUserRepository;
use ITK\Core\Persistence\Eloquent\CommissionWorkerProfileRepository;
use ITK\Core\Persistence\Eloquent\LogRepository;
use ITK\Core\Persistence\Eloquent\PosSalesTrxRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        $this->app->bind(PosSalesTrxRepositoryInterface::class, PosSalesTrxRepository::class);
        $this->app->bind(CommissionWorkerProfileRepositoryInterface::class, CommissionWorkerProfileRepository::class);
        $this->app->bind(BusinessUserRepositoryInterface::class, BusinessUserRepository::class);

        $this->app->bind(LogRepositoryInterface::class, LogRepository::class);
    }

    public function boot() {
    }
}
