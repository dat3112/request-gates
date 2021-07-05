<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function findCategory($status)
    {
        return DB::table('categories')
        ->select('*')
        ->where('status', '=', $status)
        ->whereNull('deleted_at')
        ->get();
    }
    public function findCategoryByUser($userId)
    {
        return DB::table('categories')
        ->select('*')
        ->where('user_id', $userId)
        ->whereNull('deleted_at')
        ->get();
    }
}
