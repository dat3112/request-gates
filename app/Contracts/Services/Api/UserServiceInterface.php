<?php

namespace App\Contracts\Services\Api;

interface UserServiceInterface
{
    public function index($params);
    public function searchUser($request);
    public function findByRoleId($role, $request);
    public function changePassword($data);
    public function updateUser($id, $data);
    public function forgotPassword($data);
    public function resetPassword($data);
    public function updateStatusUser($id);
    public function createUser($data);
    public function callBackGoogle($data);
    public function settingAccount($data);
}
