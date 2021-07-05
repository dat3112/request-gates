<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    /**
     * DepartmentRepository constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    public function findDepartment($status)
    {
        return DB::table('departments')
        ->select('*')
        ->where('status', $status)
        ->whereNull('deleted_at')
        ->get();
    }
}
