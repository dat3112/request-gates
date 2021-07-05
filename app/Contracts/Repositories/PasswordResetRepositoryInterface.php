<?php

namespace App\Contracts\Repositories;

interface PasswordResetRepositoryInterface extends BaseRepositoryInterface
{
    public function updateByEmail($data);
    public function findCreateAtByEmail($param);
    public function updatePassword($data);
    public function deleteResetRepository($data);
}
