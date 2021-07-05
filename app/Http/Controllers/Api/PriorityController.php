<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\PriorityServiceInterface;

class PriorityController extends ApiController
{
    /**
     * PriorityController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param IndexRequest $request
     * @param PriorityServiceInterface $priorityService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(PriorityServiceInterface $priorityService)
    {
        return $this->getData(function () use ($priorityService) {
            return $priorityService->index();
        });
    }
}
