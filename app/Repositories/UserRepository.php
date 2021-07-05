<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    public function findByRoleId($role, $request)
    {
        $status = $request['status'];
        return DB::table('users')
            ->select('*')
            ->where('role_id', '=', $role)
            ->when(!empty($request['status']), function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->whereNull('deleted_at')
            ->get();
    }
    public function findByEmail($email)
    {
        return $this->model->where('email', '=', $email)
            ->whereNull('deleted_at')
            ->first();
    }
    public function findManager($departmentId)
    {
        return DB::table('users')
            ->select('*')
            ->where('department_id', '=', $departmentId)
            ->where('role_id', '=', config('constants.ROLE.QLBP'))
            ->whereNull('deleted_at')
            ->get();
    }
    public function findUser($params)
    {
        return $this->getColumns(['*'], ['department'])
            ->where('name', 'like', '%' . $params['search'] . '%')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate($params['per_page'] ?? config('constants.PER_PAGE'));
    }

    public function findRequestByUser($userId)
    {
        return DB::table('requests')
            ->where('assign_id', '=', $userId)
            ->where('status_id', '<>', config('constants.STATUS.CLOSE'))
            ->whereNull('deleted_at')
            ->get();
    }

    public function findAdmin()
    {
        return DB::table('users')
            ->where('role_id', '=', config('constants.ROLE.ADMIN'))
            ->where('status', '=', config('constants.USER.STATUS.ACTIVE'))
            ->whereNull('deleted_at')
            ->get();
    }
}
