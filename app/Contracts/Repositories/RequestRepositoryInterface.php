<?php

namespace App\Contracts\Repositories;

interface RequestRepositoryInterface extends BaseRepositoryInterface
{
    public function findRequest($data);
    public function listRequest();
    public function listRequestDepartment($departmentID);
    public function listEmailAssign($nextDay);
}
