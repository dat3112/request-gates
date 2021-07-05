<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Users\CreateUserRequest;
use App\Http\Requests\Api\Users\IndexRequest;
use App\Http\Requests\Api\Users\ChangePassword;
use App\Http\Requests\Api\Users\ForgotPasswordRequest;
use App\Http\Requests\Api\Users\ResetpasswordRequest;
use App\Http\Requests\Api\Users\SettingAccountRequest;
use App\Http\Requests\Api\Users\UpdateUser;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    /**
     * UserController constructor.
     */
    public function __construct(Request $request)
    {
        parent::__construct();
    }
    /**
     * @param IndexRequest $request
     * @param UserServiceInterface $userService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(Request $params, UserServiceInterface $userService)
    {
        $params = $params->all();
        return $this->getData(function () use ($userService, $params) {
            return $userService->index($params);
        });
    }

    public function searchUser(Request $request, UserServiceInterface $userService)
    {
        $request = $request->all();
        return $this->getData(function () use ($userService, $request) {
            return $userService->searchUser($request);
        });
    }
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function callBackGoogle(Request $request, UserServiceInterface $userService)
    {
        return $this->getData(function () use ($request, $userService) {
            return $userService->callBackGoogle($request);
        });
    }

    public function findByRoleId(Request $request, $role, UserServiceInterface $userService)
    {
        return $this->getData(function () use ($userService, $role, $request) {
            return $userService->findByRoleId($role, $request);
        });
    }

    public function changePassword(ChangePassword $request, UserServiceInterface $userService)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($userService, $data) {
            return $userService->changePassword($data);
        });
    }

    public function updateUser($id, UpdateUser $data, UserServiceInterface $userService)
    {
        $data = $data->all();
        return $this->doRequest(function () use ($userService, $id, $data) {
            return $userService->updateUser($id, $data);
        });
    }

    public function createUser(CreateUserRequest $data, UserServiceInterface $userService)
    {
        $data = $data->all();
        return $this->doRequest(function () use ($userService, $data) {
            return $userService->createUser($data);
        });
    }

    public function forgotPassword(ForgotPasswordRequest $request, UserServiceInterface $userService)
    {
        $data = $request->all();
        return $this->getData(function () use ($userService, $data) {
            return $userService->forgotPassword($data);
        });
    }

    public function resetPassword(ResetpasswordRequest $request, UserServiceInterface $userService)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($userService, $data) {
            return $userService->resetPassword($data);
        });
    }

    public function updateStatusUser($id, UserServiceInterface $userService)
    {
        return $this->doRequest(function () use ($userService, $id) {
            return $userService->updateStatusUser($id);
        });
    }
    public function settingAccount(SettingAccountRequest  $request, UserServiceInterface $userService)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($userService, $data) {
            return $userService->settingAccount($data);
        });
    }
}
