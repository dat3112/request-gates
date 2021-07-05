<?php

namespace App\Repositories;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Models\Request;
use Illuminate\Support\Facades\DB;

class RequestRepository extends BaseRepository implements RequestRepositoryInterface
{
    public $perPage=10;

    /**
     * RequestRepository constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function listRequest()
    {
        $columns = [
            'requests.id',
            'requests.name as request_name',
            'requests.content as request_content',
            'requests.created_at',
            'author.name as name_author',
            'assign.name as name_assign',
            'statuses.name as status_name',
            'categories.name as name_category',
        ];
        return $listrequest=DB::table('requests')
                ->select($columns)
                ->join('users as author', 'author.id', '=', 'requests.author_id')
                ->join('users as assign', 'assign.id', '=', 'requests.assign_id')
                ->join('categories', 'categories.id', '=', 'requests.category_id')
                ->join('statuses', 'statuses.id', '=', 'requests.status_id')
                ->whereNull('requests.deleted_at')
                ->orderBy('requests.created_at', 'desc')
                ->paginate($this->perPage);
    }

    public function findRequest($params)
    {
        $authorId=$params['author_id'];
        $statusId=$params['status_id'];
        $assignId=$params['assign_id'];
        $categoryId=$params['category_id'];
        $departmentId=$params['department_id'];
        $columns = [
            'requests.id',
            'requests.name as request_name',
            'requests.content as request_content',
            'requests.created_at',
            'author.name as name_author',
            'assign.name as name_assign',
            'statuses.name as status_name',
            'categories.name as name_category',
        ];
        return $listrequest=DB::table('requests')
                ->select($columns)
                ->join('users as author', 'author.id', '=', 'requests.author_id')
                ->join('users as assign', 'assign.id', '=', 'requests.assign_id')
                ->join('categories', 'categories.id', '=', 'requests.category_id')
                ->join('statuses', 'statuses.id', '=', 'requests.status_id')
                ->join('departments', 'departments.id', '=', 'author.department_id')
                ->where('requests.name', 'like', '%'.$params['name'].'%')
                ->where('requests.content', 'like', '%'.$params['content'].'%')
                ->where('requests.created_at', 'like', $params['created_at'].'%')
                ->when(!empty($params['author_id']), function ($query) use ($authorId) {
                    return $query->where('requests.author_id', $authorId);
                })
                ->when(!empty($params['status_id']), function ($query) use ($statusId) {
                    return $query->where('requests.status_id', $statusId);
                })
                ->when(!empty($params['assign_id']), function ($query) use ($assignId) {
                    return $query->where('requests.assign_id', $assignId);
                })
                ->when(!empty($params['category_id']), function ($query) use ($categoryId) {
                    return $query->where('requests.category_id', $categoryId);
                })
                ->when(!empty($params['department_id']), function ($query) use ($departmentId) {
                    return $query->where('departments.id', $departmentId);
                })
                ->whereNull('requests.deleted_at')
                ->orderBy('requests.created_at', 'desc')
                ->paginate($this->perPage);
    }

    public function listRequestDepartment($departmentID)
    {
        $columns = [
            'requests.id as request_id',
            'author.id as author_id',
            'assign.id as assign_id',
            'requests.name as request_name',
            'requests.content as request_content',
            'requests.created_at',
            'author.name as name_author',
            'assign.name as name_assign',
            'statuses.name as status_name',
            'categories.name as name_category'

        ];
        $listrequest=DB::table('requests')
                ->select($columns)
                ->join('users as author', 'author.id', '=', 'requests.author_id')
                ->join('users as assign', 'assign.id', '=', 'requests.assign_id')
                ->join('categories', 'categories.id', '=', 'requests.category_id')
                ->join('statuses', 'statuses.id', '=', 'requests.status_id')
                ->where('author.department_id', $departmentID)
                ->whereNull('requests.deleted_at')
                ->orderBy('requests.created_at', 'desc')
                ->paginate($this->perPage);
        return $listrequest;
    }

    public function listEmailAssign($nextDay)
    {
        return DB::table('requests')
                ->select('users.email')
                ->join('users', 'users.id', '=', 'requests.assign_id')
                ->where('status_id', '=', config('constants.STATUS.OPEN'))
                ->where('due_date', '<', $nextDay)
                ->whereNull('requests.deleted_at')
                ->get();
    }
}
