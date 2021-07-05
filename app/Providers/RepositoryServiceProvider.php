<?php

namespace App\Providers;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Repositories\RequestRepository;
use App\Contracts\Repositories\HistoryRequestRepositoryInterface;
use App\Repositories\HistoryRequestRepository;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Contracts\Repositories\StatusRepositoryInterface;
use App\Repositories\StatusRepository;
use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Repositories\PriorityRepository;
use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Contracts\Repositories\PasswordResetRepositoryInterface;
use App\Repositories\PasswordResetRepository;
use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Repositories\DepartmentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected static $repositories = [
        'user' => [
            UserRepositoryInterface::class,
            UserRepository::class,
        ],
        'request' => [
            RequestRepositoryInterface::class,
            RequestRepository::class,
        ],
        'category' => [
            CategoryRepositoryInterface::class,
            CategoryRepository::class,
        ],
        'status' => [
            StatusRepositoryInterface::class,
            StatusRepository::class,
        ],
        'HistoryRequest' => [
            HistoryRequestRepositoryInterface::class,
            HistoryRequestRepository::class,
        ],
        'priority' => [
            PriorityRepositoryInterface::class,
            PriorityRepository::class,
        ],
        'comment' => [
            CommentRepositoryInterface::class,
            CommentRepository::class,
        ],
        'passwordReset' => [
            PasswordResetRepositoryInterface::class,
            PasswordResetRepository::class,
        ],
        'department' => [
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class,
        ]
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
