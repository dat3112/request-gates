<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Category\CategoryRequest;
use App\Contracts\Services\Api\CategoryServiceInterface;

class CategoryController extends ApiController
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
     * @param CategoryServiceInterface $categoryService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(Request $request, CategoryServiceInterface $categoryService)
    {
        $params = $request->all();
        return $this->getData(function () use ($categoryService, $params) {
            return $categoryService->index($params);
        });
    }

    public function detail($id, CategoryServiceInterface $categoryService)
    {
        return $this->getData(function () use ($categoryService, $id) {
            return $categoryService->detail($id);
        });
    }

    public function store(CategoryRequest $request, CategoryServiceInterface $categoryService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($categoryService, $params) {
            return $categoryService->store($params);
        });
    }

    public function update(CategoryRequest $request, CategoryServiceInterface $categoryService, $id)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($categoryService, $params, $id) {
            return $categoryService->update($params, $id);
        });
    }
}
