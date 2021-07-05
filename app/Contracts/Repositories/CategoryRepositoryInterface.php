<?php

namespace App\Contracts\Repositories;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function findCategory($status);
    public function findCategoryByUser($id);
}
