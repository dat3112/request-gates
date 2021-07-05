<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\StatusServiceInterface;

class StatusController extends ApiController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param IndexRequest $request
     * @param StatusServiceInterface $statusService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(StatusServiceInterface $statusService)
    {
        return $this->getData(function () use ($statusService) {
            return $statusService->index();
        });
    }
}
