<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CategoryService extends AbstractService implements CategoryServiceInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepositoryInterface $userRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        $status = $params['status'] ?? 'all';
        if (!Redis::hexists('category', $status)) {
            if ($status == 'all') {
                $category = $this->categoryRepository->getColumns(['*'], ['assign'])->get();
            } else {
                $category = $this->categoryRepository->findCategory($status);
            }
            Redis::hmset('category', $status, $category);
            Redis::expire('category', config('constants.CATEGORY.TIME_CACHE'));
        }
        return json_decode(Redis::hmget('category', $status)[0]);
    }
    
    public function detail($id)
    {
        return $this->categoryRepository->getColumns(['*'], ['assign'])->where('id', $id)->get();
    }
    public function store($params)
    {
        $this->categoryRepository->store($params);
        if (Redis::exists('category')) {
            Redis::del('category');
        }
        return [
            'message' => config('constants.CATEGORY.STORE.SUCCESS'),
        ];
    }
    public function update($params, $id)
    {
        $this->categoryRepository->find($id)->update($params);
        if (Redis::exists('category')) {
            Redis::del('category');
        }
        return [
            'message' => config('constants.CATEGORY.UPDATE.SUCCESS'),
        ];
    }
}
