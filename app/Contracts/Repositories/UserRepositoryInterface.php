<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByRoleId($role, $request);
    public function findByEmail($email);
    public function findManager($departmentId);
    public function findUser($params);
    public function findRequestByUser($userId);
    public function findAdmin();
}
