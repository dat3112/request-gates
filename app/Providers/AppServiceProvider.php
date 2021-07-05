<?php

namespace App\Providers;

use App\Services\Api\UserService;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Services\Api\RequestService;
use App\Contracts\Services\Api\HistoryRequestServiceInterface;
use App\Services\Api\HistoryRequestService;
use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Services\Api\CategoryService;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Services\Api\DepartmentService;
use App\Contracts\Services\Api\StatusServiceInterface;
use App\Services\Api\StatusService;
use App\Contracts\Services\Api\PriorityServiceInterface;
use App\Services\Api\PriorityService;
use App\Contracts\Services\Api\CommentServiceInterface;
use App\Contracts\Services\Api\ManagerRequestServiceInterface;
use App\Services\Api\CommentService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Services\Api\ManagerRequestService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $services = [
            [
                UserServiceInterface::class,
                UserService::class
            ],
            [
                ManagerRequestServiceInterface::class,
                ManagerRequestService::class
            ],
            [
                RequestServiceInterface::class,
                RequestService::class
            ],
            [
                CategoryServiceInterface::class,
                CategoryService::class
            ],
            [
                StatusServiceInterface::class,
                StatusService::class
            ],
            [
                HistoryRequestServiceInterface::class,
                HistoryRequestService::class
            ],
            [
                PriorityServiceInterface::class,
                PriorityService::class
            ],
            [
                CommentServiceInterface::class,
                CommentService::class
            ],
            [
                DepartmentServiceInterface::class,
                DepartmentService::class
            ],
        ];
        foreach ($services as $service) {
            $this->app->bind(
                $service[0],
                $service[1]
            );
        }
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
