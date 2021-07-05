<?php

namespace App\Services\Api;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Exceptions\QueryException;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Redis;

class DepartmentService extends AbstractService implements DepartmentServiceInterface
{
    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentRepository;

    /**
     * DepartmentService constructor.
     * @param DepartmentRepositoryInterface $userRepository
     */
    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        $status = $params['status'] ?? 'all';
        if (!Redis::hexists('department', $status)) {
            if ($status == 'all') {
                $department = $this->departmentRepository->getColumns(['*'])->get();
            } else {
                $department = $this->departmentRepository->findDepartment($status);
            }
            Redis::hmset('department', $status, $department);
            Redis::expire('department', config('constants.DEPARTMENT.TIME_CACHE'));
        }
        return json_decode(Redis::hmget('department', $status)[0]);
    }
    
    public function store($params)
    {
        $this->departmentRepository->store($params)->id;
        if (Redis::exists('department')) {
            Redis::del('department');
        }
        return [
            'message' => config('constants.DEPARTMENT.STORE.SUCCESS'),
        ];
    }
    public function update($params, $id)
    {
        $this->departmentRepository->find($id)->update($params);
        if (Redis::exists('department')) {
            Redis::del('department');
        }
        return [
            'message' => config('constants.DEPARTMENT.UPDATE.SUCCESS'),
        ];
    }
}
