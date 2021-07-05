<?php

namespace App\Http\Controllers\Api;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Department\CreateDepartmentRequest;
use App\Http\Requests\Api\Department\UpdateDepartmentRequest;
use App\Contracts\Services\Api\DepartmentServiceInterface;

class DepartmentController extends ApiController
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
     * @param DepartmentServiceInterface $departmentService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(Request $request, DepartmentServiceInterface $departmentService)
    {
        $params = $request->all();
        return $this->getData(function () use ($departmentService, $params) {
            return $departmentService->index($params);
        });
    }

    public function store(CreateDepartmentRequest $request, DepartmentServiceInterface $departmentService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($departmentService, $params) {
            return $departmentService->store($params);
        });
    }

    public function update(UpdateDepartmentRequest $request, DepartmentServiceInterface $departmentService, $id)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($departmentService, $params, $id) {
            return $departmentService->update($params, $id);
        });
    }
}
